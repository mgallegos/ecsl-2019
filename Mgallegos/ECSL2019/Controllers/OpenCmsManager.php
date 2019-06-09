<?php
/**
 * @file
 * Account Manager Controller.
 *
 * All ECSL2019 code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */
namespace Mgallegos\ECSL2019\Controllers;

use Mgallegos\DecimaOpenCms\OpenCms\Services\TransportationRequestManagement\TransportationRequestManagementInterface;

use Mgallegos\DecimaOpenCms\OpenCms\Services\PaymentManagement\PaymentManagementInterface;

use Mgallegos\DecimaOpenCms\OpenCms\Services\PresentationManagement\PresentationManagementInterface;

use Mgallegos\DecimaFile\File\Services\FileManagement\FileManagementInterface;

use App\Kwaai\Organization\Services\OrganizationManagement\OrganizationManagementInterface;

use Illuminate\Foundation\Application;

use Illuminate\Session\SessionManager;

use Illuminate\Http\Request;

use Illuminate\View\Factory;

use Symfony\Component\Translation\TranslatorInterface;

use App\Http\Controllers\Controller;

class OpenCmsManager extends Controller {

	/**
	 * Transportation Request Manager Service
	 *
	 * @var Mgallegos\DecimaOpenCms\OpenCms\Services\TransportationRequestManagement\TransportationRequestManagementInterface
	 *
	 */
	protected $TransportationRequestManagerService;

	/**
	 * Payment Manager Service
	 *
	 * @var Mgallegos\DecimaOpenCms\OpenCms\Services\PaymentManagement\PaymentManagementInterface
	 *
	 */
	protected $PaymentManagerService;

	/**
	 * Presentation Manager Service
	 *
	 * @var Mgallegos\DecimaOpenCms\OpenCms\Services\PresentationManagement\PresentationManagementInterface
	 *
	 */
	protected $PresentationManagerService;

	/**
	 * File Manager Service
	 *
	 * @var Mgallegos\DecimaFile\File\Services\FileManagement\FileManagementInterface
	 *
	 */
	protected $FileManagerService;

	/**
	 * Open Cms Manager Service
	 *
	 * @var Mgallegos\DecimaOpenCms\OpenCms\Services\OpenCmsManagement\OpenCmsManagementInterface
	 *
	 */
	protected $OpenCmsManagerService;

	/**
	 * Organization Manager Service
	 *
	 * @var App\Kwaai\Organization\Services\OrganizationManagement\OrganizationManagementInterface
	 *
	 */
	protected $OrganizationManagerService;

	/**
	 * View
	 *
	 * @var Illuminate\Foundation\Application
	 *
	 */
	protected $Application;

	/**
	 * View
	 *
	 * @var Illuminate\View\Factory
	 *
	 */
	protected $View;

	/**
	 * Input
	 *
	 * @var Illuminate\Http\Request
	 *
	 */
	protected $Input;

	/**
	 * Session
	 *
	 * @var Illuminate\Session\SessionManager
	 *
	 */
	protected $Session;

	/**
	 * Laravel Translator instance
	 *
	 * @var \Symfony\Component\Translation\TranslatorInterface
	 *
	 */
	protected $Lang;

	public function __construct(
		TransportationRequestManagementInterface $TransportationRequestManagerService,
		PaymentManagementInterface $PaymentManagerService,
		PresentationManagementInterface $PresentationManagerService,
		FileManagementInterface $FileManagerService,
		OrganizationManagementInterface $OrganizationManagerService,
		Application $App,
		Factory $View,
		Request $Input,
		SessionManager $Session,
		TranslatorInterface $Lang
	)
	{
		$this->TransportationRequestManagerService = $TransportationRequestManagerService;

		$this->PaymentManagerService = $PaymentManagerService;

		$this->PresentationManagerService = $PresentationManagerService;

		$this->FileManagerService = $FileManagerService;

		$this->OrganizationManagerService = $OrganizationManagerService;

		$this->App = $App;

		$this->OpenCmsManagerService = $this->App->make('ECSL2019OpenCmsManagementInterface');

		$this->View = $View;

		$this->Input = $Input;

		$this->Session = $Session;

		$this->Lang = $Lang;
	}

	public function getIndex()
	{
		$redirectToLogin = $this->Session->get('ecslLogin', false);
		$redirectToRegistro = $this->Session->get('ecslRegistro', false);
		$rememberToken = $this->Input->get('rptoken', false);
		$redirectToPago = false;
		$payment = $arrivingTransportationRequest = $leavingTransportationRequest = array();
		$cmsLoggedUser = $this->OpenCmsManagerService->getSessionLoggedUser();
		$payment['order_id'] = null;

		if(empty($cmsLoggedUser))
		{
			$guestUserDisabledCssClass = 'disabled';
			$guestUserDisabledInputAttribute = 'disabled="disabled"';
			$loggedUserDisabledCssClass = '';
			$loggedUserDisabledInputAttribute = '';
			$registroLabel = 'Registrarse';
			$cmsLoggedUser = $contacts = array();
			$cmsLoggedUserName = '';
		}
		else
		{
			$redirectToLogin = false;
			$rememberToken = false;
			$redirectToRegistro = true;
			$guestUserDisabledCssClass = '';
			$guestUserDisabledInputAttribute = '';
			$loggedUserDisabledCssClass = 'disabled';
			$loggedUserDisabledInputAttribute = 'disabled="disabled"';
			$registroLabel = 'Actualizar mis datos';
			$cmsLoggedUser['birth_date'] = \Carbon\Carbon::createFromFormat('Y-m-d', $cmsLoggedUser['birth_date'])->format($this->Lang->get('form.phpShortDateFormat'));
			$cmsLoggedUserName = $cmsLoggedUser['firstname'] . ' ' . $cmsLoggedUser['lastname'];
			$payment = $this->PaymentManagerService->getPayment($cmsLoggedUser['payment_id'], $this->OpenCmsManagerService->getCmsDatabaseConnectionName())->toArray();
			$arrivingTransportationRequest = $this->TransportationRequestManagerService->getTransportationRequest($cmsLoggedUser['arriving_transportation_request_id'], $this->OpenCmsManagerService->getCmsDatabaseConnectionName())->toArray();
			$leavingTransportationRequest = $this->TransportationRequestManagerService->getTransportationRequest($cmsLoggedUser['leaving_transportation_request_id'], $this->OpenCmsManagerService->getCmsDatabaseConnectionName())->toArray();
			$contacts = $this->OpenCmsManagerService->getUserContacts($cmsLoggedUser['user_id'], false);

			if(!empty($arrivingTransportationRequest['pickup_datetime']))
			{
				$PickupDatetime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $arrivingTransportationRequest['pickup_datetime']);
				$arrivingTransportationRequest['date'] = $PickupDatetime->format('Y-m-d');
				$arrivingTransportationRequest['hour'] = $PickupDatetime->format('H:i');
			}

			if(!empty($leavingTransportationRequest['pickup_datetime']))
			{
				$PickupDatetime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $leavingTransportationRequest['pickup_datetime']);
				$leavingTransportationRequest['date'] = $PickupDatetime->format('Y-m-d');
				$leavingTransportationRequest['hour'] = $PickupDatetime->format('H:i');
			}
		}

		$token = $this->Session->get('token', '');
		$ern = $this->Session->get('ern', '');
		$transactionStatusMessage = false;

		if(!empty($token))
		{
			$redirectToLogin = false;
			$redirectToRegistro = false;
			$rememberToken = false;
			$redirectToPago = true;
			$transactionStatusMessage = $this->OpenCmsManagerService->getTransactionStatus($token);
			$payment = $this->PaymentManagerService->getPayment($cmsLoggedUser['payment_id'], $this->OpenCmsManagerService->getCmsDatabaseConnectionName())->toArray();
		}

		// TESTING
		// $this->OpenCmsManagerService->confirmPayment('ABC001', '2019-01-01 12:00:00');

		return $this->View->make('ecsl-2019::dashboard')
			->with('login', $redirectToLogin)
			->with('rememberToken', $rememberToken)
			->with('registro', $redirectToRegistro)
			->with('pago', $redirectToPago)
			->with('guestUserDisabledCssClass', $guestUserDisabledCssClass)
			->with('guestUserDisabledInputAttribute', $guestUserDisabledInputAttribute)
			->with('loggedUserDisabledCssClass', $loggedUserDisabledCssClass)
			->with('loggedUserDisabledInputAttribute', $loggedUserDisabledInputAttribute)
			->with('cmsLoggedUser', $cmsLoggedUser)
			->with('cmsLoggedUserName', $cmsLoggedUserName)
			->with('registroLabel', $registroLabel)
			->with('token', $token)
			->with('ern', $ern)
			->with('transactionStatusMessage', $transactionStatusMessage)
			->with('payment', $payment)
			->with('arrivingTransportationRequest', $arrivingTransportationRequest)
			->with('leavingTransportationRequest', $leavingTransportationRequest)
			->with('topics', $this->PresentationManagerService->getPresentationTopics(
					$this->OpenCmsManagerService->getCmsEventId(),
					$this->OpenCmsManagerService->getCmsOrganizationId(),
					$this->OpenCmsManagerService->getCmsDatabaseConnectionName()
				)
			)
			->with('status', $this->OpenCmsManagerService->getDefaultStatus())
			->with('places', $this->OpenCmsManagerService->getPlaces())
			->with('countries', $this->OrganizationManagerService->getSystemCountries())
			->with('contacts', $contacts);
	}

	/**
	 * Handle a POST request for import user
	 *
	 * @return Response
	 */
	public function postImport()
	{
		return $this->OpenCmsManagerService->importLastYearData( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for user registration.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		return $this->OpenCmsManagerService->create( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for user registration.
	 *
	 * @return Response
	 */
	public function postUpdate()
	{
		return $this->OpenCmsManagerService->update( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for user login.
	 *
	 * @return Response
	 */
	public function postLogin()
	{
		return $this->OpenCmsManagerService->attemptLogin( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for user login.
	 *
	 * @return Response
	 */
	public function postPasswordReminder()
	{
		return $this->OpenCmsManagerService->remindPassword( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for user login.
	 *
	 * @return Response
	 */
	public function postPasswordReset()
	{
		return $this->OpenCmsManagerService->resetPassword( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for user login.
	 *
	 * @return Response
	 */
	public function postLogout()
	{
		return $this->OpenCmsManagerService->attemptLogout();
	}

	/**
	 * Handle a POST request for updating a payment.
	 *
	 * @return Response
	 */
	public function postPaymentType()
	{
		return $this->OpenCmsManagerService->setPaymentType( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for a payment.
	 *
	 * @return Response
	 */
	public function postPayment()
	{
		return $this->OpenCmsManagerService->attemptPayment( $this->Input->all() );
	}

	/**
	 * Handle a POST request for a payment authorization.
	 *
	 * @return Response
	 */
	public function postAuthorizeEcsl2019Payment()
	{
		return $this->OpenCmsManagerService->authorizePayment( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for a payment authorization.
	 *
	 * @return Response
	 */
	public function postAuthorizeEcsl2019Presentation()
	{
		return $this->OpenCmsManagerService->authorizePresentation( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for a payment authorization.
	 *
	 * @return Response
	 */
	public function postAuthorizeEcsl2019TransportationRequest()
	{
		return $this->OpenCmsManagerService->authorizeTransportationRequest( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for a payment.
	 *
	 * @return Response
	 */
	public function postUpdateTransportationRequest()
	{
		return $this->OpenCmsManagerService->updateTransportationRequest( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for a payment.
	 *
	 * @return Response
	 */
	public function postCreatePresentation()
	{
		return $this->OpenCmsManagerService->createPresentation( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for a payment.
	 *
	 * @return Response
	 */
	public function postUpdatePresentation()
	{
		return $this->OpenCmsManagerService->updatePresentation( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for a payment.
	 *
	 * @return Response
	 */
	public function postDeletePresentation()
	{
		return $this->OpenCmsManagerService->deletePresentation( $this->Input->json()->all() );
	}

	/**
	 * Handle a POST request for generating letter.
	 *
	 * @return Response
	 */
	public function postGenerateInvitationLetter()
	{
		return $this->OpenCmsManagerService->generateInvitationLetter( $this->Input->all() );
	}

	/**
	 * Handle a POST request for generating letter.
	 *
	 * @return Response
	 */
	public function postGenerateInvoice()
	{
		return $this->OpenCmsManagerService->generateInvoice( $this->Input->all() );
	}

	/**
	 * Handle a POST request for uploading a file.
	 *
	 * @return Response
	 */
	public function postUpload()
	{
		return $this->OpenCmsManagerService->uploadFile($this->Input->all(), $this->Input->file('file-uploader-file'));
	}

	/**
	 * Handle a POST request for getting element files
	 *
	 * @return Response
	 */
	 public function postElementFiles()
 	{
 		return $this->FileManagerService->getElementFiles( $this->Input->json('systemReferences'), false, $this->OpenCmsManagerService->getCmsDatabaseConnectionName(), $this->OpenCmsManagerService->getCmsOrganizationId());
 	}

	/**
	 * Handle a POST request for deleting a file
	 *
	 * @return Response
	 */
	 public function postDeleteFile()
 	{
 		return $this->FileManagerService->delete(
			$this->Input->json()->all(),
			true,
			$this->OpenCmsManagerService->getCmsDatabaseConnectionName(),
			$this->OpenCmsManagerService->getCmsOrganizationId(),
			$this->OpenCmsManagerService->getCmsVirtualAssistantId(),
			$this->OpenCmsManagerService->getCmsOrganizationId()
		);
 	}
}
