<?php
/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace Mgallegos\ECSL2019\Services\OpenCmsManagement;

use Carbon\Carbon;

use Barryvdh\DomPDF\PDF;

use nusoap_client;

use Illuminate\Contracts\Hashing\Hasher;

use Illuminate\Auth\Passwords\PasswordBroker;

use Illuminate\Auth\Passwords\PasswordBrokerManager;

use Illuminate\Config\Repository;

use Illuminate\Http\Request;

use Illuminate\Cookie\CookieJar;

use Illuminate\Session\SessionManager;

use Illuminate\Routing\Redirector;

use Illuminate\Routing\UrlGenerator;

use Illuminate\Validation\Factory;

use Illuminate\Log\Writer;

use Illuminate\Database\DatabaseManager;

use Illuminate\Mail\Mailer;

use Symfony\Component\Translation\TranslatorInterface;

use App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface;

use Mgallegos\DecimaOpenCms\OpenCms\Services\UserManagement\UserManagementInterface;

use Mgallegos\DecimaOpenCms\OpenCms\Services\SettingManagement\SettingManagementInterface;

use Mgallegos\DecimaOpenCms\OpenCms\Services\OpenCmsManagement\OpenCmsManager;

use Mgallegos\DecimaOpenCms\OpenCms\Services\PaymentManagement\PaymentManagementInterface;

use Mgallegos\DecimaOpenCms\OpenCms\Services\TransportationRequestManagement\TransportationRequestManagementInterface;

use Mgallegos\DecimaOpenCms\OpenCms\Services\PresentationManagement\PresentationManagementInterface;

use Mgallegos\DecimaSale\Sale\Services\ClientManagement\ClientManagementInterface;

use Mgallegos\DecimaSale\Sale\Services\OrderManagement\SaleOrderManagementInterface;

use Mgallegos\DecimaFile\File\Services\FileManagement\FileManagementInterface;

use Mgallegos\DecimaOpenCms\OpenCms\Repositories\User\UserInterface;

use Mgallegos\DecimaOpenCms\OpenCms\Repositories\UserEvent\UserEventInterface;

use Mgallegos\DecimaOpenCms\OpenCms\Repositories\UserContact\UserContactInterface;

use Mgallegos\ECSL2019\Repositories\RegistrationForm\RegistrationFormInterface;

use Mgallegos\ECSL2019\Repositories\CardTouch\CardTouchInterface;

use Mgallegos\DecimaOpenCms\OpenCms\Repositories\Payment\PaymentInterface;

use App\Kwaai\System\Repositories\Currency\CurrencyInterface;

use App\Kwaai\Organization\Repositories\Organization\OrganizationInterface;

use App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface;

use App\Kwaai\Helpers\Gravatar;

use App\Kwaai\Security\Repositories\Journal\JournalInterface;

class Ecsl2019OpenCmsManager extends OpenCmsManager {

	/**
   * Gravatar instance
   *
   * @var App\Kwaai\Helpers\Gravatar
   *
   */
  protected $Gravatar;

	/**
	 * PDF Creator
	 *
	 * @var Barryvdh\DomPDF\PDF
	 */
	protected $Dompdf;

  /**
	 * Payment Manager Service
	 *
	 * @var Mgallegos\DecimaOpenCms\OpenCms\Services\PaymentManagement\PaymentManagementInterface
	 *
	 */
	protected $PaymentManager;

  /**
	 * TransportationRequest Manager Service
	 *
	 * @var Mgallegos\DecimaOpenCms\OpenCms\Services\TransportationRequestManagement\TransportationRequestManagementInterface
	 *
	 */
	protected $TransportationRequestManager;

  /**
	 * Presentation Manager Service
	 *
	 * @var Mgallegos\DecimaOpenCms\OpenCms\Services\PresentationManagement\PresentationManagementInterface
	 *
	 */
	protected $PresentationManager;

  /**
	 * Sale Order Manager Service
	 *
	 * @var Mgallegos\DecimaSale\Sale\Services\ClientManagement\ClientManagementInterface
	 *
	 */
	protected $ClientManager;

  /**
	 * Sale Order Manager Service
	 *
	 * @var Mgallegos\DecimaSale\Sale\Services\OrderManagement\SaleOrderManagementInterface
	 *
	 */
	protected $SaleManager;

  /**
	 * File Manager Service
	 *
	 * @var use Mgallegos\DecimaFile\File\Services\FileManagement\FileManagementInterface
	 *
	 */
	protected $FileManager;

  /**
	* Virtual assistant id
	*
	* @var Integer
	*/
	protected $virtualAssistantId;

  /**
	* Event id
	*
	* @var Integer
	*/
	protected $eventId;

  /**
	* Organization id
	*
	* @var Integer
	*/
	protected $organizationId;

  /**
	* CMS Database Connection
	*
	* @var Integer
	*/
	protected $cmsDatabaseConnectionName;

	public function __construct(
    AuthenticationManagementInterface $AuthenticationManager,
		JournalManagementInterface $JournalManager,
		Gravatar $Gravatar,
		UserManagementInterface $UserManager,
		SettingManagementInterface $SettingManager,
    PaymentManagementInterface $PaymentManager,
		TransportationRequestManagementInterface $TransportationRequestManager,
		PresentationManagementInterface $PresentationManager,
    ClientManagementInterface $ClientManager,
    SaleOrderManagementInterface $SaleManager,
		FileManagementInterface $FileManager,
		JournalInterface $Journal,
		OrganizationInterface $Organization,
		CurrencyInterface $Currency,
		UserInterface $User,
		UserEventInterface $UserEvent,
		UserContactInterface $UserContact,
		RegistrationFormInterface $RegistrationForm,
		CardTouchInterface $CardTouch,
		// PaymentInterface $Payment,
		TranslatorInterface $Lang,
		UrlGenerator $Url,
		Redirector $Redirector,
		CookieJar $Cookie,
		Request $Input,
		Repository $Config,
		PasswordBrokerManager $Password,
		Hasher $Hash,
		SessionManager $Session,
		Factory $Validator,
		Writer $Log,
    DatabaseManager $DB,
		Mailer $Mailer,
    Carbon $Carbon,
		PDF $Dompdf
	)
	{
    $this->AuthenticationManager = $AuthenticationManager;

		$this->JournalManager = $JournalManager;

		$this->Gravatar = $Gravatar;

    $this->UserManager = $UserManager;

    $this->SettingManager = $SettingManager;

    $this->Journal = $Journal;

		$this->Organization = $Organization;

		$this->User = $User;

    $this->UserEvent = $UserEvent;

    $this->UserContact = $UserContact;

		$this->RegistrationForm = $RegistrationForm;

		$this->CardTouch = $CardTouch;

		// $this->Payment = $Payment;

		$this->Currency = $Currency;

		$this->Lang = $Lang;

		$this->Url = $Url;

		$this->Redirector = $Redirector;

		$this->Cookie = $Cookie;

		$this->Input = $Input;

		$this->Config = $Config;

		$this->Password = $Password;

		$this->Hash = $Hash;

		$this->Session = $Session;

		$this->Validator = $Validator;

    $this->Log = $Log;

    $this->DB = $DB;

		$this->Mailer = $Mailer;

    $this->Carbon = $Carbon;

		$this->Dompdf = $Dompdf;

    $this->organizationId = 29;

		$this->organizationName = 'ECSL 2019';

    $this->cmsDatabaseConnectionName = 'ecsl2019';

    $this->virtualAssistantId = 65;

    $this->eventId = 1;

    $this->eventPrefix = 'ecsl2019slca';

		$this->eventName = 'ECSL 2019';

		$this->replyToEmail = 'ecsl2019@softwarelibre.ca';

		$this->replyToName = 'Comité Organizador del ECSL 2019';

		$this->adminEmail = 'mgallegos@decimaerp.com';

		$this->timezone = 'America/Guatemala';

		$this->PaymentManager = $PaymentManager;

		$this->TransportationRequestManager = $TransportationRequestManager;

		$this->PresentationManager = $PresentationManager;

		$this->ClientManager = $ClientManager;

		$this->SaleManager = $SaleManager;

		$this->FileManager = $FileManager;

		$this->rules = array(
			'kwaai_name' => 'honeypot',
			'kwaai_time' => 'required|honeytime:2',
			'email' => 'required|email',
			'password' => 'min:6|required|same:password_confirmation'
		);

		$this->messages = array(
			'email.email' => $this->Lang->get('security/user-management.invalidEmailInfoMessage'),
			'password.min' => $this->Lang->get('security/user-management.passwordsMinLengthInfoMessage'),
			'password.same' => $this->Lang->get('security/user-management.passwordsDoNotMatchInfoMessage')
		);

    $this->registrationFields = array(
      'participated_in_ecsl2009',
      'participated_in_ecsl2010',
      'participated_in_ecsl2011',
      'participated_in_ecsl2012',
      'participated_in_ecsl2013',
      'participated_in_ecsl2014',
      'participated_in_ecsl2015',
      'participated_in_ecsl2016',
      'participated_in_ecsl2017',
      'participated_in_ecsl2018',
      'is_debian_linux_user',
      'is_mint_linux_user',
      'is_arch_linux_user',
      'is_slackware_linux_user',
      'is_opensuse_linux_user',
      'is_knoppix_linux_user',
      'is_centos_linux_user',
      'is_elementary_linux_user',
      'is_damn_linux_user',
      'is_dream_linux_user',
      'is_fedora_linux_user',
      'is_gentoo_linux_user',
      'is_antergos_linux_user',
      'is_ubuntu_linux_user',
      'custom_distribution',
      'registration_form_id',
    );
	}

	/**
   * Get organization id
   *
   * @return integer
   */
  public function getCmsOrganizationId()
	{
		return $this->organizationId;
	}

	/**
   * Get organization id
   *
   * @return integer
   */
  public function getCmsOrganizationName()
	{
		return $this->organizationName;
	}

	/**
   * Get CMS database connection
   *
   * @return string
   */
  public function getCmsDatabaseConnectionName()
	{
		return $this->cmsDatabaseConnectionName;
	}

	/**
   * Get CMS virtual assistant ID
   *
   * @return string
   */
  public function getCmsVirtualAssistantId()
	{
		return $this->virtualAssistantId;
	}

	/**
   * Get CMS database connection
   *
   * @return string
   */
  public function getCmsEventId()
	{
		return $this->eventId;
	}

	/**
   * Get default status
   *
   * @return array
   */
  public function getDefaultStatus()
	{
		return 'En revisión';
	}

	/**
   * Get
   *
   * @return array
   */
  public function getPlaces()
	{
		return array(
			'Aeropuerto Internacional de El Salvador "Monseñor Oscar Arnulfo Romero"' => 'Aeropuerto Internacional de El Salvador "Monseñor Oscar Arnulfo Romero"',
			'Puerto Bus' => 'Puerto Bus',
			'Pullmantur San Benito' => 'Pullmantur San Benito',
			'Tica Bus Terminal San Benito' => 'Tica Bus Terminal San Benito',
			'Terminal Platinum Sheraton Presidente' => 'Terminal Platinum Sheraton Presidente',
			'Transportes El Sol Terminal San Benito' => 'Transportes El Sol Terminal San Benito'
		);
	}

	/**
   * Get user registration data
   *
   * @return array
   *  An array of arrays as follows: array($userId0 => array('country'=>$country,…), $userId1 => array('country'=>$country,…),…)
   */
  public function getUsersRegistrationData()
  {
    $data = array();

    $this->RegistrationForm->byOrganization($this->organizationId, $this->cmsDatabaseConnectionName)->each(function($RegistrationForm) use (&$data)
    {
      $data[$RegistrationForm->user_id] = array('country' => $RegistrationForm->country, 'institution' => $RegistrationForm->institution);
    });

    return $data;
  }

	/**
   * Get gender stats
   *
   * @return array
   *  An array of arrays as follows: array($userId0 => array('country'=>$country,…), $userId1 => array('country'=>$country,…),…)
   */
  public function getGenderStats()
  {
    $data = array();

    $this->RegistrationForm->genderStats($this->cmsDatabaseConnectionName)->each(function($RegistrationForm) use (&$data)
    {
      $data[] = (array)$RegistrationForm;
    });

    return $data;
  }

	/**
   * Get countries stats
   *
   * @return array
   *  An array of arrays as follows: array($userId0 => array('country'=>$country,…), $userId1 => array('country'=>$country,…),…)
   */
  public function getCountriesStats()
  {
    $data = array();

    $this->RegistrationForm->countriesStats($this->cmsDatabaseConnectionName)->each(function($RegistrationForm) use (&$data)
    {
      $data[] = (array)$RegistrationForm;
    });

    return $data;
  }

	/**
   * Get institutions stats
   *
   * @return array
   *  An array of arrays as follows: array($userId0 => array('country'=>$country,…), $userId1 => array('country'=>$country,…),…)
   */
  public function getInstitutionsStats()
  {
    $data = array();

    $this->RegistrationForm->institutionsStats($this->cmsDatabaseConnectionName)->each(function($RegistrationForm) use (&$data)
    {
      $data[] = (array)$RegistrationForm;
    });

    // var_dump($data);
    return $data;
  }

	/**
   * Get user contacts
   *
   * @return array
   *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
   */
  public function getUserContacts($userId, $returnJson = true)
  {
		$contacts = array();

    $this->RegistrationForm->contactsByUserIdByEventIdAndByOrganizationId($userId, $this->eventId, $this->organizationId, $this->cmsDatabaseConnectionName)->each(function($Contact) use (&$contacts)
    {
      array_push($contacts, array(
        'id' => $Contact->id,
        'firstname' => $Contact->firstname,
        'lastname' => $Contact->lastname,
        'email' => $Contact->email,
        'country' => $Contact->country,
        'institution' => $Contact->institution,
        'gravatar_url' => $this->Gravatar->buildGravatarURL($Contact->email, 75)
      ));
    });

    if($returnJson)
    {
      return json_encode($contacts);
    }

    return $contacts;
  }

  /**
   * Get participant contacts
   *
   * @return array
   *  An array of arrays as follows: array( array('label'=>$name0, 'value'=>$id0), array('label'=>$name1, 'value'=>$id1),…)
   */
  public function getParticipantsInformation($returnJson = true)
  {
		$participants = array();

    $this->RegistrationForm->participantsByOrganizationId($this->organizationId, $this->cmsDatabaseConnectionName)->each(function($Participant) use (&$participants)
    {
      array_push($participants, array(
        'id' => $Participant->id,
        'firstname' => $Participant->firstname,
        'lastname' => $Participant->lastname,
        'email' => $Participant->email,
        'country' => $Participant->country,
        'institution' => $Participant->institution,
        'gravatar_url' => $this->Gravatar->buildGravatarURL($Participant->email, 40)
      ));
    });

    if($returnJson)
    {
      return json_encode($participants);
    }

    return $participants;
  }


	/**
	 * Unset registration fields
	 *
	 * @param array &$input
	 *
	 * @return void
	 */
	public function unsetRegistrationFields(&$input)
  {
    unset(
      $input['_token'],
      $input['fc_kwaai_name'],
      $input['fc_kwaai_time']
    );

    foreach ($this->registrationFields as $key => $field)
    {
      unset($input[$field]);
    }
  }

	/**
	 * Create a new CMS User.
	 *
	 * @param array $input
	 *	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'password'=>$password, 'is_active'=>$is_active, 'created_by'=>$created_by);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessSaveMessage}
	 *  In form does not pass validation: {"validationFailed":true, "fieldValidationMessages":{$field0:$message0, $field1:$message1,…}}
	 */
	public function create(array $input, $openTransaction = true)
	{
    $this->rules = array(
			'fc_kwaai_name' => 'honeypot',
			'fc_kwaai_time' => 'required|honeytime:2',
			'email' => 'required|email',
			'password' => 'min:6|required|same:password_confirmation'
		);

		if(!isset($input['fc_kwaai_name']))
		{
			die('sorry!');
		}

		$data = array(
      'fc_kwaai_name' => $input['fc_kwaai_name'],
			'fc_kwaai_time' => $input['fc_kwaai_time'],
			'email' => $input['email'],
			'password' => $input['password'],
			'password_confirmation' => $input['password_confirmation']
		);

		if( $this->with( $data )->fails() )
		{
			return json_encode(array('validationFailed' => true , 'fieldValidationMessages' => $this->singleMessageStringByField()));
		}

		$input = eloquent_array_filter_for_insert($input);
		$input['event_id'] = $this->eventId;

		//La validación debe ser por evento
		if(!$this->User->byEmailAndByOrganization($input['email'], $this->organizationId, $this->cmsDatabaseConnectionName)->isEmpty())
		{
			return json_encode(array('validationFailed' => true , 'fieldValidationMessages' => array('email' => $this->Lang->get('security/user-management.UserExistsException'))));
		}

    $registrationForm = array_only(
      $input,
      $this->registrationFields
    );

    $this->unsetRegistrationFields($input);

    unset($registrationForm['registration_form_id']);

		$this->beginTransaction($openTransaction, $this->cmsDatabaseConnectionName);

		try
		{
      $response = json_decode(
        $this->UserManager->create(
          $input,
          false,
          false,
          $this->cmsDatabaseConnectionName,
          $this->organizationId,
          $this->virtualAssistantId
        ),
				true
			);

      if(!empty($response['validationFailed']))
  		{
        $this->rollBack($openTransaction);

  			return json_encode(array('validationFailed' => true , 'fieldValidationMessages' => $response['fieldValidationMessages']));
  		}

      if(!empty($response['info']))
  		{
        $this->rollBack($openTransaction);

  			return json_encode(array('info' => $response['info']));
  		}

      $registrationForm['user_id'] = $response['id'];

      $RegistrationForm = $this->RegistrationForm->create(
        $registrationForm,
        $this->cmsDatabaseConnectionName
      );

      $context = array_only($input, ['firstname', 'lastname', 'email']);

      $this->Log->info('[SECURITY EVENT] A new user has registered at ECSL 2019', $context);

			$this->commit($openTransaction);
		}
		catch (\Exception $e)
    {
				$this->rollBack($openTransaction);

				throw $e;
		} catch (\Throwable $e)
    {
				$this->rollBack($openTransaction);

				throw $e;
		}

		$subject = '[ECSL 2019] Confirmación de registro ' . $this->Carbon->createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'), 'UTC')->setTimezone($this->timezone)->format($this->Lang->get('form.phpDateFormat'));
		$replyToEmail = 'ecsl2019@softwarelibre.ca';
		$replyToName = 'Comité Organizador del ECSL 2019';

		$this->Mailer->queue('ecsl-2019::emails.registro', array('addressee' => $context['firstname']), function($message) use ($context, $subject, $replyToEmail, $replyToName)
		{
			$message->to($context['email'])->subject($subject)->replyTo($replyToEmail, $replyToName)
				->cc('ecsl2019@softwarelibre.ca')
				->bcc('mgallegos@decimaerp.com');
		});

		// $subject = '[ECSL 2019] Interesado en competencia de seguidores en línea ' . $this->Carbon->createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'), 'UTC')->setTimezone($this->timezone)->format($this->Lang->get('form.phpDateFormat'));

		// if(!empty($input['is_interested_in_competition']))
		// {
		// 	$this->Mailer->queue('ecsl-2019::emails.competencia', array('name' => $context['firstname'] . ' ' . $context['lastname'], 'email' => $context['email'], 'country' => $input['country']), function($message) use ($context, $subject, $replyToEmail, $replyToName)
		// 	{
		// 		$message->to('karla.hdz4@gmail.com')->subject($subject)->replyTo($replyToEmail, $replyToName)
		// 			->cc('mario.gomez@teubi.co')
		// 			->bcc('mgallegos@decimaerp.com');
		// 	});
		// }

		return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage')));
	}

	/**
	 * Update user.
	 *
	 * @param array $input
	 *	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'password'=>$password, 'is_active'=>$is_active, 'created_by'=>$created_by);
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessSaveMessage}
	 *  In form does not pass validation: {"validationFailed":true, "fieldValidationMessages":{$field0:$message0, $field1:$message1,…}}
	 */
	public function update(array $input, $openTransaction = true)
	{
		$this->rules = array(
			'fc_kwaai_name' => 'honeypot',
			'fc_kwaai_time' => 'required|honeytime:2',
			'email' => 'required|email',
			'password' => 'min:6|same:password_confirmation'
		);

		if(!isset($input['fc_kwaai_name']))
		{
			die('sorry!');
		}

		$data = array(
			'fc_kwaai_name' => $input['fc_kwaai_name'],
			'fc_kwaai_time' => $input['fc_kwaai_time'],
			'email' => $input['email'],
			'password' => $input['password'],
			'password_confirmation' => $input['password_confirmation']
		);

		if( $this->with( $data )->fails() )
		{
			return json_encode(array('validationFailed' => true , 'fieldValidationMessages' => $this->singleMessageStringByField()));
		}

		$User = $this->User->byId($input['user_id'], $this->cmsDatabaseConnectionName);
		$input = eloquent_array_filter_for_update($input);

		if($User->email != $input['email'] && !$this->User->byEmailAndByOrganization($input['email'], $this->organizationId, $this->cmsDatabaseConnectionName)->isEmpty())
		{
			return json_encode(array('validationFailed' => true , 'fieldValidationMessages' => array('email' => $this->Lang->get('security/user-management.UserExistsException'))));
		}

		$cmsLoggedUser = $this->getSessionLoggedUser();

    $registrationForm = array_only(
      $input,
      $this->registrationFields
    );

    $this->unsetRegistrationFields($input);

    unset($input['user_id']);
    $registrationForm['id'] = $registrationForm['registration_form_id'];
    unset($registrationForm['registration_form_id']);

    $this->beginTransaction($openTransaction, $this->cmsDatabaseConnectionName);

		try
		{
      $response = json_decode(
        $this->UserManager->update(
          $input,
          $User,
          false,
          $this->cmsDatabaseConnectionName,
          $this->organizationId,
          $this->virtualAssistantId
        ),
				true
			);

      if(!empty($response['validationFailed']))
  		{
        $this->rollBack($openTransaction);

  			return json_encode(array('validationFailed' => true , 'fieldValidationMessages' => $response['fieldValidationMessages']));
  		}

      if(!empty($response['info']))
  		{
        $this->rollBack($openTransaction);

  			return json_encode(array('info' => $response['info']));
  		}

			// // $userInput  = array(
			// // 	'firstname' => $input['firstname'],
			// // 	'lastname' => $input['lastname'],
			// // 	'email' => $input['email']
			// // );
      // //
			// // if(isset($input['password']))
			// // {
			// // 	$userInput['password'] = bcrypt($input['password']);
			// // }
      // //
      // // $this->User->update(
			// // 	$userInput,
			// // 	$User,
			// // 	$this->cmsDatabaseConnectionName
			// // );
      // //
			// // $input['id'] = $input['registration_form_id'];
      //
      //
			// unset(
      //   $input['_token'],
      //   $input['user_id'],
      //   $input['firstname'],
      //   $input['lastname'],
      //   $input['email'],
      //   $input['password'],
      //   $input['fc_kwaai_name'],
      //   $input['fc_kwaai_time'],
      //   $input['password_confirmation'],
      //   $input['registration_form_id']
      // );
      //
			// if(isset($input['birth_date']) && !empty($input['birth_date']))
      // {
      //   $input['birth_date'] = $this->Carbon->createFromFormat($this->Lang->get('form.phpShortDateFormat'), $input['birth_date'])->format('Y-m-d');
      // }

			$RegistrationForm = $this->RegistrationForm->update(
				$registrationForm,
				null,
				$this->cmsDatabaseConnectionName
			);

			$User = $this->User->byId(
        $RegistrationForm->user_id,
        $this->cmsDatabaseConnectionName
      );
			$user = $User->toArray();
      $registrationForm = $RegistrationForm->toArray();
      $registrationForm['registration_form_id'] = $registrationForm['id'];

			unset($user['password']);

			$this->clearCache();
			$this->setCache(array_merge($registrationForm, $user));

		  // $Journal = $this->Journal->create(array('journalized_id' => $User->id, 'journalized_type' => $this->User->getTable(), 'user_id' => $input['created_by']));
		  // $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('security/user-management.adminUserAddedJournal', array('email' => $input['email'], 'organization' => $this->AuthenticationManager->getCurrentUserOrganization('name')))), $Journal);

      $context = array_only($input, ['firstname', 'lastname', 'email']);

			$this->Log->info('[SECURITY EVENT] An existing user updated his information at ECSL 2019', $context);

			$this->commit($openTransaction);
		}
		catch (\Exception $e)
    {
			$this->rollBack($openTransaction);

			throw $e;
		}
    catch (\Throwable $e)
    {
			$this->rollBack($openTransaction);

			throw $e;
		}

		// $subject = '[ECSL 2019] Interesado en competencia de seguidores en línea ' . $this->Carbon->createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'), 'UTC')->setTimezone($this->timezone)->format($this->Lang->get('form.phpDateFormat'));
		// $replyToEmail = 'ecsl2019@softwarelibre.ca';
		// $replyToName = 'Comité Organizador del ECSL 2019';
    //
		// if(empty($cmsLoggedUser['is_interested_in_competition']) && !empty($input['is_interested_in_competition']))
		// {
		// 	$this->Mailer->queue('ecsl-2019::emails.competencia', array('name' => $context['firstname'] . ' ' . $context['lastname'], 'email' => $context['email'], 'country' => $input['country']), function($message) use ($context, $subject, $replyToEmail, $replyToName)
		// 	{
		// 		$message->to('karla.hdz4@gmail.com')->subject($subject)->replyTo($replyToEmail, $replyToName)
		// 			->cc('mario.gomez@teubi.co')
		// 			->bcc('mgallegos@decimaerp.com');
		// 	});
		// }

		return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage')));
	}

	/**
	 * Update transportation request.
	 *
	 * @param array $input
	 *	An array as follows: array();
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessSaveMessage}
	 *  In form does not pass validation: {"validationFailed":true, "fieldValidationMessages":{$field0:$message0, $field1:$message1,…}}
	 */
	public function updateTransportationRequest(array $input, $openTransaction = true)
	{
		$this->rules = array(
			'kwaai_name' => 'honeypot',
			'kwaai_time' => 'required|honeytime:2'
		);

		if(!isset($input['kwaai_name']))
		{
			die('sorry!');
		}

		$data = array(
			'kwaai_name' => $input['kwaai_name'],
			'kwaai_time' => $input['kwaai_time'],
		);

		if( $this->with( $data )->fails() )
		{
			die('fail');
		}

		// var_dump($input);
		// array (size=7)
		//   'date' => string '2019-07-11' (length=10)
		//   'id' => string '6' (length=1)
		//   'hour' => string '02:01' (length=5)
		//   'duration' => string 'Aeropuerto Internacional de El Salvador "MonseÃ±or Oscar Arnulfo Romero"' (length=72)
		//   'destination' => string 'Centro Loyola' (length=13)
		//   'transport_number' => string 'dasads' (length=6)
		//   'remark' => string 'dsad' (length=4)

		$TransportationRequest = $this->TransportationRequestManager->getTransportationRequest($input['id'], $this->cmsDatabaseConnectionName);

		$input['datetime'] = $input['date'] . ' ' . $input['hour'] . ':00';
		$dateTime = $TransportationRequest->pickup_datetime;

		$this->TransportationRequestManager->update(
			array(
				'pickup_datetime' => $input['datetime'],
				'transport_number' => $input['transport_number'],
				'origin' => $input['origin'],
				'destination' => $input['destination'],
				'remark' => $input['remark']
			),
			$TransportationRequest,
			false,//$openTransaction = true,
			false,//$changeDateFormat = true,
			$this->cmsDatabaseConnectionName,//$databaseConnectionName = null,
			$this->organizationId,//$organizationId = null,
			$this->virtualAssistantId// $loggedUserId = null
		);

		if(empty($dateTime))
		{
			$subject = '[ECSL 2019] Confirmación de solicitud de transporte ' . $this->Carbon->createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'), 'UTC')->setTimezone($this->timezone)->format($this->Lang->get('form.phpDateFormat'));
			$replyToEmail = 'ecsl2019@softwarelibre.ca';
			$replyToName = 'Comité Organizador del ECSL 2019';
			$User = $this->User->byId($TransportationRequest->request_user_id, $this->cmsDatabaseConnectionName);
			$input['email'] = $User->email;
			$input['name'] = $User->firstname . ' ' . $User->lastname;
			$input['datetime'] = $this->Carbon->createFromFormat('Y-m-d H:i:s', $input['datetime'])->format($this->Lang->get('form.phpDateFormat'));

			$this->Mailer->queue('ecsl-2019::emails.solicitud-transporte', $input, function($message) use ($input, $subject, $replyToEmail, $replyToName)
			{
				$message->to($input['email'])->subject($subject)->replyTo($replyToEmail, $replyToName)
					->cc('ecsl2019@softwarelibre.ca')
					->bcc('mgallegos@decimaerp.com');
			});
		}

		return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage')));
	}

	/**
	 * Create presentation.
	 *
	 * @param array $input
	 *	An array as follows: array();
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessSaveMessage}
	 *  In form does not pass validation: {"validationFailed":true, "fieldValidationMessages":{$field0:$message0, $field1:$message1,…}}
	 */
	public function createPresentation(array $input, $openTransaction = true)
	{
		$this->rules = array(
			'fc_kwaai_name' => 'honeypot',
			'fc_kwaai_time' => 'required|honeytime:2'
		);

		if(!isset($input['fc_kwaai_name']))
		{
			die('sorry!');
		}

		$data = array(
			'fc_kwaai_name' => $input['fc_kwaai_name'],
			'fc_kwaai_time' => $input['fc_kwaai_time'],
		);

		if( $this->with( $data )->fails() )
		{
			die('fail');
		}

		// /Users/mgallegos/Documents/workspace/decima-ecsl-2019/Mgallegos/ECSL2019/Controllers/OpenCmsManager.php:286:
		// array (size=12)
		//   '_token' => string 'xpovnAuQgbIMvVtjFCqhWZxjEOeKqMOPDcFyUyad' (length=40)
		//   'kwaai_name' => string '' (length=0)
		//   'kwaai_time' => string 'eyJpdiI6IlF5Wndua2xOWDI0MTFxcGtlY3dRQnc9PSIsInZhbHVlIjoiU3hXMXRnV3MwcmlCV3p5R0o3Y2xOUT09IiwibWFjIjoiMDI1MWIyMDg1OTNmYTdiZTBjZDY0MjcyZGIwNzMxYTI2MmY1MDA0OGM1NjEwMGNhOTA1YzI3MGJmNzQxZjE5MiJ9' (length=188)
		//   'name' => string 'DecimaERP en la nube' (length=20)
		//   'id' => string '' (length=0)
		//   'type' => string 'Charla' (length=6)
		//   'duration' => string '1' (length=1)
		//   'topic' => string '5' (length=1)
		//   'description' => string 'Hello worlds' (length=12)
		//   'is_approved' => string 'En revisiÃ³n' (length=12)
		//   'space' => string '' (length=0)
		//   'scheduled_hour' => string '' (length=0)

		// $Presentation = $this->PresentationManager->getPresentation($input['id'], $this->cmsDatabaseConnectionName);

		$cmsLoggedUser = $this->getSessionLoggedUser();

		$this->PresentationManager->create(
			array(
				'name' => $input['name'],
				'description' => $input['description'],
				'type' => $input['type'],
				'duration' => $input['duration'],
				'subtopic_id' => $input['subtopic_id'],
				'user_id' => $cmsLoggedUser['user_id'],
				'event_id' => $this->eventId
			),
			true,//$openTransaction = true,
			$this->cmsDatabaseConnectionName,//$databaseConnectionName = null,
			$this->organizationId,//$organizationId = null,
			$this->virtualAssistantId// $loggedUserId = null
		);

		if(empty($dateTime))
		{
			$subject = '[ECSL 2019] Confirmación de solicitud de ponencia ' . $this->Carbon->createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'), 'UTC')->setTimezone($this->timezone)->format($this->Lang->get('form.phpDateFormat'));
			$replyToEmail = 'ecsl2019@softwarelibre.ca';
			$replyToName = 'Comité Organizador del ECSL 2019';
			$input['email'] = $cmsLoggedUser['email'];
			$input['user'] = $cmsLoggedUser['firstname'] . ' ' . $cmsLoggedUser['lastname'];

			$this->Mailer->queue('ecsl-2019::emails.solicitud-ponencia', $input, function($message) use ($input, $subject, $replyToEmail, $replyToName)
			{
				$message->to($input['email'])->subject($subject)->replyTo($replyToEmail, $replyToName)
					->cc('ecsl2019@softwarelibre.ca')
					->bcc('mgallegos@decimaerp.com');
			});
		}

		return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage')));
	}

	/**
	 * Update presentation
	 *
	 * @param array $input
	 *	An array as follows: array();
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessSaveMessage}
	 *  In form does not pass validation: {"validationFailed":true, "fieldValidationMessages":{$field0:$message0, $field1:$message1,…}}
	 */
	public function updatePresentation(array $input, $openTransaction = true)
	{
		$this->rules = array(
			'fc_kwaai_name' => 'honeypot',
			'fc_kwaai_time' => 'required|honeytime:2'
		);

		if(!isset($input['fc_kwaai_name']))
		{
			die('sorry!');
		}

		$data = array(
			'fc_kwaai_name' => $input['fc_kwaai_name'],
			'fc_kwaai_time' => $input['fc_kwaai_time'],
		);

		if( $this->with( $data )->fails() )
		{
			die('fail');
		}

		$this->PresentationManager->update(
			array(
				'id' => $input['id'],
				'name' => $input['name'],
				'description' => $input['description'],
				'type' => $input['type'],
				'duration' => $input['duration'],
				'subtopic_id' => $input['subtopic_id']
			),
			null,
			true,//$openTransaction = true,
			$this->cmsDatabaseConnectionName,//$databaseConnectionName = null,
			$this->organizationId,//$organizationId = null,
			$this->virtualAssistantId// $loggedUserId = null
		);

		return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage')));
	}

	/**
	 * Delete presentation
	 *
	 * @param array $input
	 *	An array as follows: array();
	 *
	 * @return JSON encoded string
	 *  A string as follows:
	 *  In case of success: {"success":form.defaultSuccessSaveMessage}
	 *  In form does not pass validation: {"validationFailed":true, "fieldValidationMessages":{$field0:$message0, $field1:$message1,…}}
	 */
	public function deletePresentation(array $input, $openTransaction = true)
	{
		$this->rules = array(
			'fc_kwaai_name' => 'honeypot',
			'fc_kwaai_time' => 'required|honeytime:2'
		);

		if(!isset($input['fc_kwaai_name']))
		{
			die('sorry!');
		}

		$data = array(
			'fc_kwaai_name' => $input['fc_kwaai_name'],
			'fc_kwaai_time' => $input['fc_kwaai_time'],
		);

		if( $this->with( $data )->fails() )
		{
			die('fail');
		}

		$this->PresentationManager->delete(
			array(
				'id' => array($input['id'])
			),
			true,//$openTransaction = true,
			$this->cmsDatabaseConnectionName,//$databaseConnectionName = null,
			$this->organizationId,//$organizationId = null,
			$this->virtualAssistantId// $loggedUserId = null
		);

		return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage')));
	}

	/**
   * Get payment ERN
   *
   * @param float $paymentTypeAmount
   * @param float $paymentCommissionAmount
   *
   * @return JSON integer
   */
  public function getPaymentErn($paymentTypeId, $paymentFormType, $paymentAmount, $paymentTypeAmount, $paymentCommissionAmount, $type, $description, $openTransaction = true)
  {
		$cmsLoggedUser = $this->getSessionLoggedUser();

		$this->beginTransaction($openTransaction, $this->cmsDatabaseConnectionName);

		try
		{
			$Payment = $this->PaymentManager->getPayment(
				$cmsLoggedUser['payment_id'],
				$this->cmsDatabaseConnectionName
			);

			$date = $this->Carbon->createFromFormat('Y-m-d', date('Y-m-d'), 'UTC')->setTimezone($this->timezone)->format('Y-m-d');

			if(empty($Payment->order_id))
			{
				$response = json_decode(
					$this->SaleManager->create(
						array(
							'type' => 'O',
							'status' => 'P',
							'registration_date' => $date,
							'collection_date' => $date,
							'client_id' => $cmsLoggedUser['client_id'],
							'sale_point_id' => 1,
							'payment_term_id' => 2,
							'remark' => $description,
						),
						false,
						false,
						$this->cmsDatabaseConnectionName,
						$this->organizationId,// $organizationId = null,
						$this->virtualAssistantId // $loggedUserId = null,
					),
					true
				);
			}
			else
			{
				$response['id'] = $Payment->order_id;

				$this->SaleManager->update(
					array(
						'id' => $response['id'],
						'registration_date' => $date,
						'collection_date' => $date,
						'remark' => $description
					),
					null,
					null,
					false,
					false,
					false,
					$this->cmsDatabaseConnectionName,
					$this->organizationId,// $organizationId = null,
					$this->virtualAssistantId // $loggedUserId = null,
				);
			}

			$this->PaymentManager->update(
				array(
					'order_id' => $response['id'],
					// 'payment_form_label' => 'Pago en línea (pagadito)',
					'payment_form_type' => $paymentFormType,
					'type' => $type,
					'remark' => $description,
					'amount' => $paymentAmount,
				),
				$Payment,
				false,
				false,
				$this->cmsDatabaseConnectionName,
				$this->organizationId,// $organizationId = null,
				$this->virtualAssistantId // $loggedUserId = null,
			);

			$Sale = $this->SaleManager->getSaleOrder(
				$response['id'],
				$this->cmsDatabaseConnectionName
			);

			$this->SaleManager->deleteOrderDetails(
				$response['id'],
				$this->cmsDatabaseConnectionName
			);

			$this->SaleManager->createOrderDetail(
				array(
					'quantity' => '1',
					'price_without_discount' => $paymentTypeAmount,
					'price' => $paymentTypeAmount,
					'subject_amount' => $paymentTypeAmount,
					'order_id' => $response['id'],
					'article_id' => $paymentTypeId//paquete ECSL
				),
				false,// $openTransaction = true,
				$this->cmsDatabaseConnectionName,//$databaseConnectionName = null,
				$this->organizationId,// $organizationId = null,
				$this->virtualAssistantId // $loggedUserId = null,
			);

			// comisión
			// $this->SaleManager->createOrderDetail(
			// 	array(
			// 		'quantity' => '1',
			// 		'price_without_discount' => $paymentCommissionAmount,
			// 		'price' => $paymentCommissionAmount,
			// 		'subject_amount' => $paymentCommissionAmount,
			// 		'order_id' => $response['id'],
			// 		'article_id' => 193//comisión
			// 	),
			// 	false,// $openTransaction = true,
			// 	$this->cmsDatabaseConnectionName,//$databaseConnectionName = null,
			// 	$this->organizationId,// $organizationId = null,
			// 	$this->virtualAssistantId // $loggedUserId = null,
			// );

			$this->commit($openTransaction);
		}
    catch (\Exception $e)
    {
      $this->rollBack($openTransaction);

      throw $e;
    }
    catch (\Throwable $e)
    {
      $this->rollBack($openTransaction);

      throw $e;
    }

		return $Sale->sale_order_number;
  }

	/**
   * Set payment type
   *
   * @param array $input
   *	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email);
   *
   * @return JSON encoded string
   *  A string as follows:
   */
  public function setPaymentType($input, $openTransaction = true)
  {
		$cmsLoggedUser = $this->getSessionLoggedUser();

		$this->beginTransaction($openTransaction, $this->cmsDatabaseConnectionName);

		try
		{
			$Payment = $this->PaymentManager->getPayment(
				$cmsLoggedUser['payment_id'],
				$this->cmsDatabaseConnectionName
			);

			$this->PaymentManager->update(
				array(
					'type' => $input['type'],
					'remark' => $input['remark'],
					'amount' => $input['amount'],
				),
				$Payment,
				false,
				false,
				$this->cmsDatabaseConnectionName,
				$this->organizationId,// $organizationId = null,
				$this->virtualAssistantId // $loggedUserId = null,
			);

			$this->commit($openTransaction);
		}
		catch (\Exception $e)
		{
			$this->rollBack($openTransaction);

			throw $e;
		}
		catch (\Throwable $e)
		{
			$this->rollBack($openTransaction);

			throw $e;
		}

		return json_encode(array('success' => $this->Lang->get('form.defaultSuccessSaveMessage')));
  }

	/**
   * Confirm payment
   *
   * @param array $input
   *	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email);
   *
   * @return JSON encoded string
   *  A string as follows:
   */
  public function confirmPayment($reference, $dateTrans, $openTransaction = true)
  {
		$cmsLoggedUser = $this->getSessionLoggedUser();

		$this->beginTransaction($openTransaction, $this->cmsDatabaseConnectionName);

		try
		{
			$Payment = $this->PaymentManager->getPayment(
				$cmsLoggedUser['payment_id'],
				$this->cmsDatabaseConnectionName
			);

			$this->PaymentManager->update(
				array(
					'approval_number' => $reference,
					'record_datetime' => $dateTrans,
					'status' => 'X',
				),
				$Payment,
				false,
				false,
				$this->cmsDatabaseConnectionName,
				$this->organizationId,// $organizationId = null,
				$this->virtualAssistantId // $loggedUserId = null,
			);

			$this->SaleManager->update(
				array(
					'id' => $Payment->order_id,
					'emission_date' => $this->Carbon->createFromFormat('Y-m-d', date('Y-m-d'), 'UTC')->setTimezone($this->timezone)->format('Y-m-d'),
					'document_type_id' => '7',
					'document_type_label' => 'Factura Comercial',
					'document_number' => $this->SaleManager->getDocumentNumberByDocumentTypeId(
						array(
							'sale_point_id' => '1',
							'document_type_id' => '7',
							'organization_id' => $this->organizationId
						),
						$this->cmsDatabaseConnectionName,
						false
					)
				),
				null,
				null,
				false,
				false,
				false,
				$this->cmsDatabaseConnectionName,
				$this->organizationId,// $organizationId = null,
				$this->virtualAssistantId // $loggedUserId = null,
			);

			$this->commit($openTransaction);
		}
		catch (\Exception $e)
		{
			$this->rollBack($openTransaction);

			throw $e;
		}
		catch (\Throwable $e)
		{
			$this->rollBack($openTransaction);

			throw $e;
		}

		$input['email'] = $cmsLoggedUser['email'];
		$input['name'] = $cmsLoggedUser['firstname'] . ' ' . $cmsLoggedUser['lastname'];
		$input['datetime'] = $this->Carbon->createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'), 'UTC')->setTimezone($this->timezone)->format($this->Lang->get('form.phpDateFormat'));
		$input['amount'] = $Payment->amount;
		$input['type'] = $Payment->remark;
		$input['reference'] = $reference;
		$subject = '[ECSL 2019] Confirmación de recepción de pago ' . $input['datetime'];
		$replyToEmail = 'ecsl2019@softwarelibre.ca';
		$replyToName = 'Comité Organizador del ECSL 2019';

		$this->Mailer->queue('ecsl-2019::emails.confirmacion-pago', $input, function($message) use ($input, $subject, $replyToEmail, $replyToName)
		{
			$message->to($input['email'])->subject($subject)->replyTo($replyToEmail, $replyToName)
				->cc('ecsl2019@softwarelibre.ca')
				->bcc('mgallegos@decimaerp.com');
		});
  }

  /**
   * Attempt payment
   *
   * @param array $input
   *	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email);
   *
   * @return JSON encoded string
   *  A string as follows:
   */
  public function attemptPayment(array $input)
  {
		$cmsLoggedUser = $this->getSessionLoggedUser();
		$setting = $this->SettingManager->getCurrentSettingConfiguration($this->organizationId, $this->cmsDatabaseConnectionName);

		if($setting['pagadito_environment'] == 'S')
		{
			$UID = $setting['pagadito_sandbox_uid'];
	    $WSK = $setting['pagadito_sandbox_wsk'];
	    $WSPG = $setting['pagadito_sandbox_wspg'];
		}
		else if($setting['pagadito_environment'] == 'P')
		{
			$UID = $setting['pagadito_production_uid'];
	    $WSK = $setting['pagadito_production_wsk'];
	    $WSPG = $setting['pagadito_production_wspg'];
		}

		if(!isset($input['amount']))
		{
			die('sorry!');
		}

    /*
     * Lo primero es crear el objeto nusoap_client, al que se le pasa como
     * parámetro la URL de Conexión definida en la constante WSPG
     */
    $oSoap = new nusoap_client($WSPG);

    $err = $oSoap->getError();

    if (!$err)
    {
      /*
       * Lo siguiente será consumir la operación 'connect', a la cual le
       * pasaremos el UID y WSK para solicitarle un token de conexión al WSPG.
       * Alternativamente le enviamos el formato en el que queremos que nos
       * responda el WSPG, en este ejemplo solicitamos el formato PHP.
       */
      $params = array(
          "uid"           => $UID,
          "wsk"           => $WSK,
          "format_return" => "php"
      );

      $response = $oSoap->call('connect', $params);
      $data_response = unserialize($response);

      // var_dump($data_response);die();
      // object(stdClass)[2599]
      //   public 'code' => string 'PG1001' (length=6)
      //   public 'message' => string 'Connection successful.' (length=22)
      //   public 'value' => string '75635d4f202e8428490624a8240ade0b' (length=32)
      //   public 'datetime' => string '2019-05-12 13:37:21' (length=19)

      if (!$oSoap->fault)
      {
        /*
         * Debido a que el WSPG nos puede devolver diversos mensajes de
         * respuesta, validamos el tipo de mensaje que nos devuelve.
         */
        switch($data_response->code)
        {
          case "PG1001":
            /*
             * En caso de haber recibido un token exitosamente,
             * procedemos a definir los detalles de la venta, para ello
             * definimos el siguiente arreglo.
             */
            $token = $data_response->value;
            $details = array();
            // if($_POST["cantidad1"]>0)
            // {
            //     $details[] =
            //         array(
            //             "quantity"      => $_POST["cantidad1"],
            //             "description"   => $_POST["descripcion1"],
            //             "price"         => $_POST["precio1"],
            //             "url_product"   => $_POST["url1"]
            //         );
            // }

            $details[] =
              array(
                  "quantity"      => 1,
                  "description"   => $input['description'],
                  "price"         => $input['amount'],
                  // "url_product"   => $_POST["url1"]
              );

            /*
             * A continuación, procedemos a consumir la operación
             * exec_trans, para solicitar al WSPG que registre nuestra
             * transacción. Para ello le enviamos token, ern, amount y
             * details. Alternativamente, le enviamos el formato en el
             * que queremos que nos responda el WSPG, en este ejemplo
             * solicitamos el formato PHP.
             *
             * A manera de ejemplo el ern es generado como un número
             * aleatorio entre 1000 y 2000. Lo ideal es que sea una
             * referencia almacenada por el Pagadito Comercio.
             */
            $params = array(
                "token"         => $token,
                // "ern"           => rand(1, 2000),
                "ern"           => $this->getPaymentErn($input['payment_type_id'], $input['payment_form_type'], $input['amount'], $input['payment_type_amount'], $input['payment_commission_amount'], $input['type'], $input['description']),
                "amount"        => $input['amount'],
                "details"       => json_encode($details),
                "format_return" => "php"
            );
            $response = $oSoap->call('exec_trans', $params);
            $data_response = unserialize($response);

            // var_dump($data_response);die();
            // object(stdClass)[2598]
            // public 'code' => string 'PG1002' (length=6)
            // public 'message' => string 'Transaction register successful.' (length=32)
            // public 'value' => string 'https://sandbox.pagadito.com/comercios/index.php?mod=login&token=817113a613f43c063043c5048bdef30f' (length=97)
            // public 'datetime' => string '2019-05-12 13:19:51' (length=19)

            /*
             * Debido a que el WSPG nos puede devolver diversos mensajes
             * de respuesta, validamos el tipo de mensaje que nos
             * devuelve.
             */
            switch($data_response->code)
            {
	            case "PG1002":
                /*
                 * En caso de haberse registrado la transacción
                 * exitosamente, redireccionamos al usuario a la
                 * URL devuelta por el WSPG.
                 */
                // header("Location: $data_response->value");
								$this->Log->info(
									'[SECURITY EVENT] Pagadito transaction registered',
									array(
										'firstname' => $cmsLoggedUser['firstname'],
										'lastname' => $cmsLoggedUser['lastname'],
										'email' => $cmsLoggedUser['email'],
										'code' => $data_response->code,
										'value' => $data_response->value,
									)
								);

                return $this->Redirector->to($data_response->value);

                break;
	            case "PG2001":
                /*
                 * Tratamiento para datos incompletos.
                 */
	            case "PG3002":
                /*
                 * Tratamiento para error.
                 */
	            case "PG3003":
                /*
                 * Tratamiento para transacción no registrada.
                 */
	            case "PG3004":
                /*
                 * Tratamiento para monto desigual
                 */
	            case "PG3006":
                /*
                 * Tratamiento para monto excedido.
                 */
	            case "PG3007":
                /*
                 * Tratamiento para acceso denegado.
                 */
	            default:
                /*
                 * Por ser un ejemplo, se muestra en una ventana
                 * emergente el código y mensaje de la respuesta
                 * del WSPG
                 */
                // echo "
                //     <SCRIPT>
                //         alert(\"$data_response->code: $data_response->message\");
                //         location.href = 'index.php';
                //     </SCRIPT>
                // ";
								$this->Log->info(
									'[SECURITY EVENT] Pagadito transaction failed',
									array(
										'firstname' => $cmsLoggedUser['firstname'],
										'lastname' => $cmsLoggedUser['lastname'],
										'email' => $cmsLoggedUser['email'],
										'code' => $data_response->code,
										'message' => $data_response->message,
									)
								);
                break;
            }
            break;
          case "PG2001":
            /*
             * Tratamiento para datos incompletos.
             */
          case "PG3001":
            /*
             * Tratamiento para conexión dengada.
             */
          case "PG3002":
            /*
             * Tratamiento para error.
             */
          case "PG3005":
            /*
             * Tratamiento para conexión deshabilitada.
             */
          default:
            /*
             * Por ser un ejemplo, se muestra en una ventana
             * emergente el código y mensaje de la respuesta
             * del WSPG
             */
            // echo "
            //     <SCRIPT>
            //         alert(\"$data_response->code: $data_response->message\");
            //         location.href = 'index.php';
            //     </SCRIPT>
            // ";
						$this->Log->info(
							'[SECURITY EVENT] Pagadito connection failed',
							array(
								'firstname' => $cmsLoggedUser['firstname'],
								'lastname' => $cmsLoggedUser['lastname'],
								'email' => $cmsLoggedUser['email'],
								'code' => $data_response->code,
								'message' => $data_response->message,
							)
						);
            break;
        }
      }
      else
      {
        /*
         * Por ser un ejemplo, se muestra en una ventana emergente el
         * mensaje de error devuelto por el objeto oSoap.
         */
        // echo "
        //     <SCRIPT>
        //         alert('".$oSoap->getError()."');
        //         location.href = 'index.php';
        //     </SCRIPT>
        // ";
				$this->Log->info(
					'[SECURITY EVENT] Pagadito soap error',
					array(
						'firstname' => $cmsLoggedUser['firstname'],
						'lastname' => $cmsLoggedUser['lastname'],
						'email' => $cmsLoggedUser['email'],
						'error' => $oSoap->getError(),
					)
				);
      }
    }
    else
    {
      /*
       * Por ser un ejemplo, se muestra en una ventana emergente el mensaje de
       * error devuelto por el objeto oSoap.
       */
      // echo "
      //     <SCRIPT>
      //         alert('".$err."');
      //         location.href = 'index.php';
      //     </SCRIPT>
      // ";
			$this->Log->info(
				'[SECURITY EVENT] Pagadito soap error',
				array(
					'firstname' => $cmsLoggedUser['firstname'],
					'lastname' => $cmsLoggedUser['lastname'],
					'email' => $cmsLoggedUser['email'],
					'error' => $err,
				)
			);
    }
  }

	/**
	 * Authorize payment
	 *
	 * @param array $input
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1
   *                            );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessSaveMessage}
	 */
	public function authorizePayment(array $input, $openTransaction = true, $changeDateFormat = true)
	{
		$organizationId = $this->AuthenticationManager->getCurrentUserOrganizationId();
		$loggedUserId = $this->AuthenticationManager->getLoggedUserId();

		if(empty($loggedUserId))
		{
			return json_encode(array('info' => 'System user is not logged in'));
		}

    if(isset($input['record_datetime']) && !empty($input['record_datetime']) && $changeDateFormat)
    {
      $recordDatetime = $this->Carbon->createFromFormat($this->Lang->get('form.phpDateTimeFormat'), $input['record_datetime']);
      $input['record_datetime'] = $recordDatetime->format('Y-m-d H:i:s');
    }

    $this->beginTransaction($openTransaction, $this->cmsDatabaseConnectionName);

    try
		{
			$Payment = $this->PaymentManager->getPayment(
				$input['id'],
				$this->cmsDatabaseConnectionName
			);
      $User = $this->User->byId(
				$Payment->user_id,
				$this->cmsDatabaseConnectionName
			);
      $RegistrationForm = $this->RegistrationForm->byUserId(
				$Payment->user_id,
				$this->cmsDatabaseConnectionName
			)->first();
      $date = $this->Carbon->createFromFormat('Y-m-d', date('Y-m-d'), 'UTC')
        ->setTimezone($this->timezone)
        ->format('Y-m-d');

			if($input['payment_form_type'] != 'J')
			{
				$articlesId['A'] = 190;
	      $articlesId['B'] = 191;
	      $articlesId['C'] = 192;

				if(empty($Payment->order_id))
				{
					$response = json_decode(
						$this->SaleManager->create(
							array(
								'type' => 'O',
								'status' => 'P',
								'registration_date' => $date,
								'emission_date' => $date,
								'collection_date' => $recordDatetime->format('Y-m-d'),
								'payment_date' => $recordDatetime->format('Y-m-d'),
								'client_id' => $User->client_id,
								'sale_point_id' => 1,
	              'document_type_id' => '7',
	    					'document_type_label' => 'Factura Comercial',
								'payment_term_id' => 1,
								'payment_form_id' => 2,
								'bank_account_id' => 1,
								'remark' => $input['remark'],
	              'document_number' => $this->SaleManager->getDocumentNumberByDocumentTypeId(
	    						array(
	    							'sale_point_id' => '1',
	    							'document_type_id' => '7',
	    							'organization_id' => $organizationId
	    						),
	    						$this->cmsDatabaseConnectionName,
	    						false
	    					)
							),
							false,
							false,
							$this->cmsDatabaseConnectionName,
							$organizationId,// $organizationId = null,
							$loggedUserId // $loggedUserId = null,
						),
						true
					);
				}
				else
				{
	        $response['id'] = $Payment->order_id;

					$this->SaleManager->update(
	          array(
	            'id' => $response['id'],
	            'type' => 'O',
	            'status' => 'P',
	            'registration_date' => $date,
	            'emission_date' => $date,
	            'collection_date' => $recordDatetime->format('Y-m-d'),
	            'payment_date' => $recordDatetime->format('Y-m-d'),
	            'client_id' => $RegistrationForm->client_id,
	            'sale_point_id' => 1,
	            'sale_point_label' => 'Oficina central',
	            'document_type_id' => '7',
	            'document_type_label' => 'Factura Comercial',
	            'payment_term_id' => 1,
	            'payment_term_label' => 'Contado',
	            'payment_form_id' => 2,
	            'payment_form_label' => 'Transferencia bancaria',
	            'bank_account_id' => 1,
	            'bank_account_label' => 'Moisés Oswaldo Larín y Carlos Juan Martín Pérez (Banco de América Central)',
	            'remark' => $input['remark'],
	            'document_number' => $this->SaleManager->getDocumentNumberByDocumentTypeId(
	              array(
	                'sale_point_id' => '1',
	                'document_type_id' => '7',
	                'organization_id' => $organizationId
	              ),
	              $this->cmsDatabaseConnectionName,
	              false
	            )
	          ),
						null,
						null,
						false,
						false,
						false,
						$this->cmsDatabaseConnectionName,
						$organizationId,// $organizationId = null,
						$loggedUserId // $loggedUserId = null,
					);

	        $this->SaleManager->deleteOrderDetails(
	  				$response['id'],
	  				$this->cmsDatabaseConnectionName
	  			);
				}

	      $Sale = $this->SaleManager->getSaleOrder(
					$response['id'],
					$this->cmsDatabaseConnectionName
				);

	      $this->SaleManager->createOrderDetail(
					array(
						'quantity' => '1',
						'price_without_discount' => $input['amount'],
						'price' => $input['amount'],
						'subject_amount' => $input['amount'],
						'order_id' => $response['id'],
						'article_id' => $articlesId[$input['type']]
					),
					false,// $openTransaction = true,
	        $this->cmsDatabaseConnectionName,
	        $organizationId,// $organizationId = null,
	        $loggedUserId // $loggedUserId = null,
				);
			}
			else
			{
				$response['id'] = null;
			}

      // 'order_id' => $response['id'],

      $input['status'] = 'X';
      $input['order_id'] = $response['id'];

      $this->PaymentManager->update(
				$input,
				$Payment,
				false,
				false,
				$this->cmsDatabaseConnectionName,
				$organizationId,// $organizationId = null,
				$loggedUserId // $loggedUserId = null,
			);

      $Journal = $this->Journal->create(array('journalized_id' => $Payment->id, 'journalized_type' => $Payment->getTable(), 'user_id' => $loggedUserId, 'organization_id' => $organizationId));
      $this->Journal->attachDetail($Journal->id, array('note' => $this->Lang->get('decima-open-cms::payment-management.authorizedJournal', array('name' => $User->firstname . ' ' . $User->lastname)), $Journal));

      $this->commit($openTransaction);
    }
    catch (\Exception $e)
    {
      $this->rollBack($openTransaction);

      throw $e;
    }
    catch (\Throwable $e)
    {
      $this->rollBack($openTransaction);

      throw $e;
    }

		if($input['payment_form_type'] != 'J')
		{
			$input['email'] = $User->email;
			$input['name'] = $User->firstname . ' ' . $User->lastname;
			$input['datetime'] = $this->Carbon->createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'), 'UTC')->setTimezone($this->timezone)->format($this->Lang->get('form.phpDateFormat'));
			$input['amount'] = $input['amount'];
			$input['type'] = $input['type_label'];
			$input['reference'] = $input['approval_number'];
			$subject = '[ECSL 2019] Confirmación de recepción de pago ' . $input['datetime'];
			$replyToEmail = 'ecsl2019@softwarelibre.ca';
			$replyToName = 'Comité Organizador del ECSL 2019';

			// $input['email'] = 'mgallegos@decimaerp.com';

			$this->Mailer->queue('ecsl-2019::emails.confirmacion-pago', $input, function($message) use ($input, $subject, $replyToEmail, $replyToName)
			{
				$message->to($input['email'])->subject($subject)->replyTo($replyToEmail, $replyToName)
					->cc('ecsl2019@softwarelibre.ca')
					->bcc('mgallegos@decimaerp.com');
			});
		}

    return json_encode(array('success' => $this->Lang->get('form.defaultSuccessOperationMessage'), 'id' => $Payment->id));
  }

	/**
	 * Authorize presentation
	 *
	 * @param array $input
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1
   *                            );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessSaveMessage}
	 */
	public function authorizePresentation(array $input, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
	{
		$response = $this->PresentationManager->authorize($input, true, $databaseConnectionName, $organizationId, $loggedUserId);

		$decodedResponse = json_decode($response, true);

		if(!empty($decodedResponse['success']))
		{
			$User = $this->User->byId(
				$input['user_id'],
				$this->cmsDatabaseConnectionName
			);

			$input['title'] = $input['name'];
			$input['email'] = $User->email;
			$input['name'] = $User->firstname;
			$input['datetime'] = $this->Carbon->createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'), 'UTC')->setTimezone($this->timezone)->format($this->Lang->get('form.phpDateFormat'));
			$subject = '[ECSL 2019] Confirmación de aceptación de ponencia ' . $input['datetime'];
			$replyToEmail = 'ecsl2019@softwarelibre.ca';
			$replyToName = 'Comité Organizador del ECSL 2019';

			// $input['email'] = 'mgallegos@decimaerp.com';

			$this->Mailer->queue('ecsl-2019::emails.confirmacion-ponencia', $input, function($message) use ($input, $subject, $replyToEmail, $replyToName)
			{
				$message->to($input['email'])->subject($subject)->replyTo($replyToEmail, $replyToName)
					->cc('ecsl2019@softwarelibre.ca')
					->bcc('mgallegos@decimaerp.com');
			});
		}

		return $response;
	}

	/**
	 * Authorize presentation
	 *
	 * @param array $input
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1
   *                            );
   *
	 * @return JSON encoded string
	 *  A string as follows:
	 *	In case of success: {"success" : form.defaultSuccessSaveMessage}
	 */
	public function authorizeTransportationRequest(array $input, $openTransaction = true, $databaseConnectionName = null, $organizationId = null, $loggedUserId = null)
	{
		$response = $this->TransportationRequestManager->authorize($input, true, $databaseConnectionName, $organizationId, $loggedUserId);

		$decodedResponse = json_decode($response, true);

		if(!empty($decodedResponse['success']))
		{
			$User = $this->User->byId(
				$input['request_user_id'],
				$this->cmsDatabaseConnectionName
			);

			$input['email'] = $User->email;
			$input['name'] = $User->firstname;
			$input['datetime'] = $this->Carbon->createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'), 'UTC')->setTimezone($this->timezone)->format($this->Lang->get('form.phpDateFormat'));
			$subject = '[ECSL 2019] Confirmación de asignación de transporte ' . $input['datetime'];
			$replyToEmail = 'ecsl2019@softwarelibre.ca';
			$replyToName = 'Comité Organizador del ECSL 2019';

			// $input['email'] = 'mgallegos@decimaerp.com';

			$this->Mailer->queue('ecsl-2019::emails.confirmacion-transporte', $input, function($message) use ($input, $subject, $replyToEmail, $replyToName)
			{
				$message->to($input['email'])->subject($subject)->replyTo($replyToEmail, $replyToName)
					->cc('ecsl2019@softwarelibre.ca')
					->bcc('mgallegos@decimaerp.com');
			});
		}

		return $response;
	}

  /**
   * Make payment
   *
   * @param array $input
   *	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email);
   *
   * @return JSON encoded string
   *  A string as follows:
   */
  public function getTransactionStatus($tokenTrans)
  {
		$cmsLoggedUser = $this->getSessionLoggedUser();
		$setting = $this->SettingManager->getCurrentSettingConfiguration($this->organizationId, $this->cmsDatabaseConnectionName);

		if($setting['pagadito_environment'] == 'S')
		{
			$UID = $setting['pagadito_sandbox_uid'];
	    $WSK = $setting['pagadito_sandbox_wsk'];
	    $WSPG = $setting['pagadito_sandbox_wspg'];
		}
		else if($setting['pagadito_environment'] == 'P')
		{
			$UID = $setting['pagadito_production_uid'];
	    $WSK = $setting['pagadito_production_wsk'];
	    $WSPG = $setting['pagadito_production_wspg'];
		}

		/*
     * Lo primero es crear el objeto nusoap_client, al que se le pasa como
     * parámetro la URL de Conexión definida en la constante WSPG
     */
    $oSoap = new nusoap_client($WSPG);

    $err = $oSoap->getError();

    if (!$err)
    {
      /*
       * Lo siguiente será consumir la operación 'connect', a la cual le
       * pasaremos el UID y WSK para solicitarle un token de conexión al WSPG.
       * Alternativamente le enviamos el formato en el que queremos que nos
       * responda el WSPG, en este ejemplo solicitamos el formato PHP.
       */
      $params = array(
        "uid"           => $UID,
        "wsk"           => $WSK,
        "format_return" => "php"
      );
      $response = $oSoap->call('connect', $params);
      $data_response = unserialize($response);

      if (!$oSoap->fault)
      {
        /*
         * Debido a que el WSPG nos puede devolver diversos mensajes de
         * respuesta, validamos el tipo de mensaje que nos devuelve.
         */
        switch($data_response->code)
        {
          case "PG1001":
            /*
             * En caso de haber recibido un token exitosamente,
             * procedemos a consumir la operación 'get_status'
             * enviándole al WSPG el token de conexión y el token
             * recibido por GET, que es el que consultaremos.
             */
            $token = $data_response->value;
            $params = array(
                "token"         => $token,
                "token_trans"   => $tokenTrans,
                "format_return" => "php"
            );
            $response = $oSoap->call('get_status', $params);
            $data_response = unserialize($response);

            /*
             * Debido a que el WSPG nos puede devolver diversos mensajes
             * de respuesta, validamos el tipo de mensaje que nos
             * devuelve.
             */
            switch($data_response->code)
            {
              case "PG1003":
                /*
                 * En caso de haberse obtenido el estado de la
                 * transacción exitosamente, validamos el estado
                 * devuelto.
                 */
                switch ($data_response->value['status'])
                {
                	case "COMPLETED":
                    /*
                     * Tratamiento para una transacción exitosa.
                     */
                    // $msg = "Gracias por comprar en Mi Tienda Pagadito.<br /><br />Referencia: ".$data_response->value['reference']."<br />Fecha: ".$data_response->value['date_trans'];

										$this->confirmPayment($data_response->value['reference'], $data_response->value['date_trans']);

										$this->Log->info(
											'[SECURITY EVENT] Pagadito transaction completed',
											array(
												'firstname' => $cmsLoggedUser['firstname'],
												'lastname' => $cmsLoggedUser['lastname'],
												'email' => $cmsLoggedUser['email'],
												'status' => $data_response->value['status'],
												'reference' => $data_response->value['reference'],
												'date_trans' => $data_response->value['date_trans']
											)
										);

										return true;

                    // return "Su pago fue procesado exitosamente, gracias por confirmar su participación al ECSL 2019.<br />El número de referencia de su pago es: " .
										// 	$data_response->value['reference'] .
										// 	" con fecha y hora: " .
										// 	$this->Carbon->createFromFormat('Y-m-d H:i:s', $data_response->value['date_trans'])->format($this->Lang->get('form.phpDateFormat'));
                    break;
                  case "REGISTERED":
                    /*
                     * Tratamiento para una transacción aún en
                     * proceso.
                     */

										$this->Log->info(
											'[SECURITY EVENT] Pagadito transaction registered but not completed',
 											array(
 												'firstname' => $cmsLoggedUser['firstname'],
 												'lastname' => $cmsLoggedUser['lastname'],
 												'email' => $cmsLoggedUser['email'],
 												'status' => $data_response->value['status']
 											)
 										);

                    return "La transacci&oacute;n a&uacute;n est&aacute; en proceso, le confirmaremos vía correo electrónico cuando sea completada.";
                    break;
                  case "FAILED":
                    /*
                     * Tratamiento para una transacción fallida.
                     */
                  default:
                    /*
                     * Por ser un ejemplo, se muestra un mensaje
                     * de error fijo.
                     */
                    // $msg = "Lo sentimos, la compra no pudo realizarse.";
										$this->Log->info(
											'[SECURITY EVENT] Pagadito transaction failed',
											array(
												'firstname' => $cmsLoggedUser['firstname'],
												'lastname' => $cmsLoggedUser['lastname'],
												'email' => $cmsLoggedUser['email'],
												'status' => $data_response->value['status']
											)
										);
                    break;
                }
                break;
              case "PG2001":
                /*
                 * Tratamiento para datos incompletos.
                 */
              case "PG3002":
                /*
                 * Tratamiento para error.
                 */
              case "PG3003":
                /*
                 * Tratamiento para transacción no registrada.
                 */
              case "PG3007":
                /*
                 * Tratamiento para acceso denegado.
                 */
              default:
                /*
                 * Por ser un ejemplo, se muestra un mensaje
                 * de error fijo.
                 */
                // $msg = "Lo sentimos, ha ocurrido un problema :/";
								$this->Log->info(
									'[SECURITY EVENT] Pagadito transaction error',
									array(
										'firstname' => $cmsLoggedUser['firstname'],
										'lastname' => $cmsLoggedUser['lastname'],
										'email' => $cmsLoggedUser['email'],
										'status' => $data_response->value['status']
									)
								);
                break;
            }
            break;
          case "PG2001":
            /*
             * Tratamiento para datos incompletos.
             */
          case "PG3001":
            /*
             * Tratamiento para conexión denegada.
             */
          case "PG3002":
            /*
             * Tratamiento para error.
             */
          case "PG3005":
            /*
             * Tratamiento para conexión deshabilitada.
             */
          default:
            /*
             * Por ser un ejemplo, se muestra en una ventana
             * emergente el código y mensaje de la respuesta
             * del WSPG
             */
            // echo "
            //     <SCRIPT>
            //         alert(\"$data_response->code: $data_response->message\");
            //         location.href = 'index.php';
            //     </SCRIPT>
            // ";
						// $msg = "$data_response->code: $data_response->message";
						$this->Log->info(
							'[SECURITY EVENT] Pagadito transaction error',
							array(
								'firstname' => $cmsLoggedUser['firstname'],
								'lastname' => $cmsLoggedUser['lastname'],
								'email' => $cmsLoggedUser['email'],
								'code' => $data_response->code,
								'message' => $data_response->message
							)
						);
            break;
        }
      }
      else
      {
	      /*
	       * Por ser un ejemplo, se muestra en una ventana emergente el
	       * mensaje de error devuelto por el objeto oSoap.
	       */
	      // echo "
	      //     <SCRIPT>
	      //         alert('".$oSoap->getError()."');
	      //         location.href = 'index.php';
	      //     </SCRIPT>
	      // ";
				$this->Log->info(
					'[SECURITY EVENT] Pagadito soap error',
					array(
						'firstname' => $cmsLoggedUser['firstname'],
						'lastname' => $cmsLoggedUser['lastname'],
						'email' => $cmsLoggedUser['email'],
						'message' => $oSoap->getError()
					)
				);
      }
	  }
	  else
	  {
      /*
       * Por ser un ejemplo, se muestra en una ventana emergente el mensaje de
       * error devuelto por el objeto oSoap.
       */
      // echo "
      //     <SCRIPT>
      //         alert('".$err."');
      //         location.href = 'index.php';
      //     </SCRIPT>
      // ";
			$this->Log->info(
				'[SECURITY EVENT] Pagadito soap error',
				array(
					'firstname' => $cmsLoggedUser['firstname'],
					'lastname' => $cmsLoggedUser['lastname'],
					'email' => $cmsLoggedUser['email'],
					'message' => $err
				)
			);
	  }

		return false;
  }

	/**
   * Generate invitation letter
   *
   * @param array $input
   *	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email);
   *
   * @return JSON encoded string
   *  A string as follows:
   */
  public function generateInvitationLetter(array $input)
  {
		$cmsLoggedUser = $this->getSessionLoggedUser();

		$Date = $this->Carbon->createFromFormat('Y-m-d', date('Y-m-d'), 'UTC')->setTimezone($this->timezone);
		$formattedDay = $this->Lang->get('week-days.' . strtolower($Date->format('l'))) . ' ' . $Date->format('d') . ' de ' . strtolower($this->Lang->get('decima-accounting::period-management.' . (int)$Date->format('m'))) . ' de ' . $Date->format('Y');

		return $this->Dompdf
			->loadView('ecsl-2019::carta-invitacion-pdf', array('name' => $cmsLoggedUser['firstname'] . ' ' . $cmsLoggedUser['lastname'], 'date' => $formattedDay))
			->setPaper('letter')
			->stream('Carta_ECSL_2019.pdf');
  }

	/**
   * Generate invitation letter
   *
   * @param array $input
   *	An array as follows: array('firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email);
   *
   * @return JSON encoded string
   *  A string as follows:
   */
  public function generateInvoice(array $input)
  {
		$cmsLoggedUser = $this->getSessionLoggedUser();
		$cmsLoggedUser = $this->getSessionOrganization();

		return $this->SaleManager->createDefaultPdf(
			array(
				'sale_order_id' => $input['order_id'],
				'print_format_identifier' => 'EC0001'
			),
			$this->cmsDatabaseConnectionName,//$databaseConnectionName = null,
			$this->virtualAssistantId, // $loggedUserId = null,
			$this->organizationId,// $organizationId = null,
			$this->getSessionOrganization()//$organization = null
		);
  }

	/**
   * Upload file
   *
   * @param array $input
   * @param file $file
   *
   * @return JSON encoded string
   *  A string as follows:
   */
  public function uploadFile(array $input, $file)
  {
		$cmsLoggedUser = $this->getSessionLoggedUser();

		$response = $this->FileManager->saveFile(
			$input,
			$file,
			true,
			$this->getCmsDatabaseConnectionName(),
			$this->getCmsOrganizationId(),
			$this->getCmsVirtualAssistantId(),
			$this->getCmsOrganizationId(),
			$this->getCmsOrganizationName()
		);

		$decodedResponse = json_decode($response, true);

		if(!empty($decodedResponse['success']) && $input['journal_id'] != 'presentation-management')
		{
			$data['url'] = $decodedResponse['dataFiles'][0]['url'];
			$data['email'] = $cmsLoggedUser['email'];
			$data['name'] = $cmsLoggedUser['firstname'] . ' ' . $cmsLoggedUser['lastname'];
			$data['datetime'] = $this->Carbon->createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'), 'UTC')->setTimezone($this->timezone)->format($this->Lang->get('form.phpDateFormat'));
			$subject = '[ECSL 2019] Confirmación de subida de archivo ' . $data['datetime'];
			$replyToEmail = 'ecsl2019@softwarelibre.ca';
			$replyToName = 'Comité Organizador del ECSL 2019';

			$this->Mailer->queue('ecsl-2019::emails.confirmacion-registo-comprobante', $data, function($message) use ($data, $subject, $replyToEmail, $replyToName)
			{
				$message->to($data['email'])->subject($subject)->replyTo($replyToEmail, $replyToName)
					// ->cc('ecsl2019@softwarelibre.ca')
					->bcc('mgallegos@decimaerp.com');
			});

			$this->Log->info(
				'[SECURITY EVENT] A new file was upload from ECSL 2019',
				array(
					'firstname' => $cmsLoggedUser['firstname'],
					'lastname' => $cmsLoggedUser['lastname'],
					'email' => $cmsLoggedUser['email'],
					'file' => $data['url']
				)
			);
		}

		return $response;
  }

	/**
   * SAOH 01
   *
   * @param array $input
   *
   * @return JSON encoded string
   *  A string as follows: []
   */
  public function saoh01(array $input)
  {
		$Organization = $this->AuthenticationManager->getOrganizationByApiToken($input['token']);

    if(empty($Organization))
    {
     die('sorry!');
    }

    if($Organization->database_connection_name != $this->cmsDatabaseConnectionName)
    {
     die('sorry!');
    }

		$users = $saoh = array();
		$payments = $this->PaymentManager->getPaymentsData($this->organizationId, $this->cmsDatabaseConnectionName);

		$this->User->byOrganization($this->organizationId, $this->cmsDatabaseConnectionName)->each(function($User) use (&$users)
    {
      $users[$User->id] = $User->firstname . ' ' . $User->lastname;
    });

		foreach ($payments as $key => $payment)
		{
			if($payment['status'] == 'X')
			{
				if($payment['type'] == 'A')
				{
					$saoh[] = array('id' => $payment['user_id'], 'class' => 2, 'name' => $users[$payment['user_id']]);
				}
				else
				{
					$saoh[] = array('id' => $payment['user_id'], 'class' => 1, 'name' => $users[$payment['user_id']]);
				}
			}
		}

		return json_encode($saoh);
  }

	/**
   * SAOH 02
   *
   * @param array $input
   *
   * @return JSON encoded string
   *  A string as follows: []
   */
  public function saoh02(array $input)
  {
		$Organization = $this->AuthenticationManager->getOrganizationByApiToken($input['token']);

    if(empty($Organization))
    {
     die('sorry!');
    }

    if($Organization->database_connection_name != $this->cmsDatabaseConnectionName)
    {
     die('sorry!');
    }

		$saoh = array();

		foreach ($input['data'] as $key => $value)
		{
			$CardTouch = $this->CardTouch->create(
				array(
					'event_id' => $value['event_id'],
					'event_type_id' => $value['event_type_id'],
					'reader_id' => $value['reader_id'],
					'reader_name' => $value['reader_name'],
					'user_id' => $value['data'][0]['user_id'],
					'timestamp' => $this->Carbon->createFromFormat('Y-m-d\TH:i:s\Z', $value['timestamp'])->format('Y-m-d H:i:s')
				),
				$this->cmsDatabaseConnectionName
			);
			$saoh[] = array('event_id' => $value['event_id']);
		}

		return json_encode($saoh);
  }

	/**
   * SAOH 03
   *
   * @param array $input
   *
   * @return JSON encoded string
   *  A string as follows: []
   */
  public function saoh03(array $input)
  {
		$Organization = $this->AuthenticationManager->getOrganizationByApiToken($input['token']);

    if(empty($Organization))
    {
     die('sorry!');
    }

    if($Organization->database_connection_name != $this->cmsDatabaseConnectionName)
    {
     die('sorry!');
    }

		$saoh = array();

		foreach ($input['data'] as $key => $value)
		{
			$this->UserContact->create(
        array(
          'user_id' => $value['data'][0]['user_id'],
          'user_contact_id' => $value['data'][1]['user_id'],
          'event_id' => $this->eventId,
          'organization_id' => $this->organizationId,
        ),
        $this->cmsDatabaseConnectionName
      );

			$this->UserContact->create(
        array(
          'user_id' => $value['data'][1]['user_id'],
          'user_contact_id' => $value['data'][0]['user_id'],
					'event_id' => $this->eventId,
          'organization_id' => $this->organizationId,
        ),
        $this->cmsDatabaseConnectionName
      );

			$saoh[] = array('event_id' => $value['event_id']);
		}

		return json_encode($saoh);
  }
}
