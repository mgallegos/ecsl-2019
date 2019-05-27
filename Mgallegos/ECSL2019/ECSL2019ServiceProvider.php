<?php namespace Mgallegos\ECSL2019;

use Carbon\Carbon;

use Illuminate\Support\ServiceProvider;

class ECSL2019ServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	* Bootstrap any application services.
	*
	* @return void
	*/
	public function boot()
	{
		include __DIR__.'/../../routes.php';

		$this->loadViewsFrom(__DIR__.'/../../views', 'ecsl-2019');

		$this->loadTranslationsFrom(__DIR__.'/../../lang', 'ecsl-2019');

		$this->publishes([
				__DIR__ . '/../../config/config.php' => config_path('ecsl-2019-general.php'),
		], 'config');

		$this->mergeConfigFrom(
				__DIR__ . '/../../config/config.php', 'ecsl-2019-general'
		);

		$this->publishes([
				__DIR__ . '/../../config/journal.php' => config_path('ecsl-2019-journal.php'),
		], 'config');

		$this->mergeConfigFrom(
				__DIR__ . '/../../config/journal.php', 'ecsl-2019-journal'
		);

		$this->publishes([
    __DIR__.'/../../migrations/' => database_path('/migrations')
		], 'migrations');

		$this->publishes([
	    __DIR__.'/../../assets/' => public_path('/mgallegos/ecsl-2019')
		], 'public');

		$this->registerCustomPrintFormats();

		$this->registerRegistrationFormInterface();

		$this->registerCardTouchInterface();

		$this->registerOpenCmsManagementInterface();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	* Register custom print formats.
	*
	* @return void
	*/
	protected function registerCustomPrintFormats()
	{
		$customPrintFormatsArray = $this->app->make('customPrintFormats');
		$customPrintFormatsArray['EC0002'] = new \Mgallegos\ECSL2019\CustomFormats\FacturaComercial($this->app->make('dompdf.wrapper'));

		$this->app->instance('customPrintFormats', $customPrintFormatsArray);
	}

	/**
	* Register a RegistrationForm interface instance.
	*
	* @return void
	*/
	protected function registerRegistrationFormInterface()
	{
		$this->app->bind('ECSL2019RegistrationFormInterface', function($app)
		{
			return new \Mgallegos\ECSL2019\Repositories\RegistrationForm\EloquentRegistrationForm( new \Mgallegos\ECSL2019\RegistrationForm(), $app['db'], 'ECSL2019');
		});
	}

	/**
	* Register a CardTouch interface instance.
	*
	* @return void
	*/
	protected function registerCardTouchInterface()
	{
		$this->app->bind('ECSL2019CardTouchInterface', function($app)
		{
			return new \Mgallegos\ECSL2019\Repositories\CardTouch\EloquentCardTouch( new \Mgallegos\ECSL2019\CardTouch(), 'ECSL2019');
		});
	}

	/**
	 * Register a ... interface instance.
	 *
	 * @return void
	 */
	protected function registerOpenCmsManagementInterface()
	{
		$this->app->bind('ECSL2019OpenCmsManagementInterface', function($app)
		{
			return new \Mgallegos\ECSL2019\Services\OpenCmsManagement\Ecsl2019OpenCmsManager(
					$app->make('App\Kwaai\Security\Services\AuthenticationManagement\AuthenticationManagementInterface'),
					$app->make('App\Kwaai\Security\Services\JournalManagement\JournalManagementInterface'),
					new \App\Kwaai\Helpers\Gravatar(),
					$app->make('Mgallegos\DecimaOpenCms\OpenCms\Services\UserManagement\UserManagementInterface'),
					$app->make('Mgallegos\DecimaOpenCms\OpenCms\Services\SettingManagement\SettingManagementInterface'),
					$app->make('Mgallegos\DecimaOpenCms\OpenCms\Services\PaymentManagement\PaymentManagementInterface'),
					$app->make('Mgallegos\DecimaOpenCms\OpenCms\Services\TransportationRequestManagement\TransportationRequestManagementInterface'),
					$app->make('Mgallegos\DecimaOpenCms\OpenCms\Services\PresentationManagement\PresentationManagementInterface'),
					$app->make('Mgallegos\DecimaSale\Sale\Services\ClientManagement\ClientManagementInterface'),
					$app->make('Mgallegos\DecimaSale\Sale\Services\OrderManagement\SaleOrderManagementInterface'),
					$app->make('Mgallegos\DecimaFile\File\Services\FileManagement\FileManagementInterface'),
					$app->make('App\Kwaai\Security\Repositories\Journal\JournalInterface'),
					$app->make('App\Kwaai\Organization\Repositories\Organization\OrganizationInterface'),
					$app->make('App\Kwaai\System\Repositories\Currency\CurrencyInterface'),
					$app->make('Mgallegos\DecimaOpenCms\OpenCms\Repositories\User\UserInterface'),
					$app->make('Mgallegos\DecimaOpenCms\OpenCms\Repositories\UserEvent\UserEventInterface'),
					$app->make('Mgallegos\DecimaOpenCms\OpenCms\Repositories\UserContact\UserContactInterface'),
					$app->make('ECSL2019RegistrationFormInterface'),
					$app->make('ECSL2019CardTouchInterface'),
					$app['translator'],
					$app['url'],
					$app['redirect'],
					$app['cookie'],
					$app['request'],
					$app['config'],
					$app['auth.password'],
					$app['hash'],
					$app['session'],
					$app['validator'],
					$app['log'],
					$app['db'],
					$app['mailer'],
					new Carbon(),
					$app->make('dompdf.wrapper')
			);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
