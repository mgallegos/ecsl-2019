<?php
// var_dump('Hola decima web');
/**
 * @file
 * Application Routes.
 *
 * All ECSL2019 code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//https://laravel.com/docs/5.1/controllers

// var_dump(Request::getHost());

$ecsl =  function ()
{
		Route::get('/ecsltest', function()
		{
			// return Redirect::to('cms/dashboard')->with('ecsl2019login', true);
			// return Redirect::to('cms/dashboard')->with('ecsl2019registro', true);

			return Redirect::to('cms/dashboard')
				->with('ecsl2019pago', true)
				->with('token', Request::get('token', ''))
				->with('ern', Request::get('ern', ''));
		});

		Route::get('/cms/logistica', function()
		{
			return View::make('ecsl-2019::logistica');
		});

		//Rutas para el desarrollador

		Route::get('/cms/inicio', function()
		{
			return View::make('ecsl-2019::inicio-personalizado');
		});

		// Route::get('/cms/inicio-cierre', function()
		// {
		// 	$app = $this->app;
		// 	$OpenCmsManagerService = $app->make('Ecsl2019OpenCmsManagementInterface');
		//
		// 	return View::make('ecsl-2019::inicio-cierre')
		// 		->with('usersData', $OpenCmsManagerService->getUsersRegistrationData())
		// 		->with('participants', $OpenCmsManagerService->getParticipantsInformation(false));
		// });

		Route::get('/cms/ejes-tematicos', function()
		{
			return View::make('ecsl-2019::ejes-tematicos');
		});

		Route::get('/cms/bases-de-competencia', function()
		{
			return View::make('ecsl-2019::bases-de-competencia');
		});

		Route::get('/cms/faq', function()
		{
			return View::make('ecsl-2019::faq');
		});

		// Route::get('/cms/ecsl/eventos-anteriores', function()
		Route::get('/cms/eventos-anteriores', function()
		{
			return View::make('ecsl-2019::eventos-anteriores');
		});

		Route::get('/cms/carta-invitacion', function()
		{
			return View::make('ecsl-2019::carta-invitacion-pdf');
		});


		Route::get('/cms/fotografias', function()
		{
			return View::make('ecsl-2019::fotografias');
		});

		Route::get('/cms/ponencias', function()
		{
			return View::make('ecsl-2019::ponencias');
		});

		Route::get('/cms/estadisticas', function()
		{
			$app = $this->app;
			$OpenCmsManagerService = $app->make('Ecsl2019OpenCmsManagementInterface');

			return View::make('ecsl-2019::estadisticas')
				->with('charts', true)
				->with('genderStats', $OpenCmsManagerService->getGenderStats())
				->with('countriesStats', $OpenCmsManagerService->getCountriesStats())
				->with('institutionsStats', $OpenCmsManagerService->getInstitutionsStats());
		});

		Route::get('/cms/agenda/{id}', function($id)
		{
			return Redirect::to('cms/agenda')->with('presentationId', $id);
		});

		// Route::get('/cms/agenda', function()
		// {
		// 	// var_dump($PresentationManagerService->getPresentationsWithSpeaker(1, 15, true, 'ecsl2019', false));
		// 	// var_dump($PresentationManagerService->getPresentationsWithSpeakerAndSchedule(1, 15, true, 'ecsl2019', false));
		//
		// 	return View::make('ecsl-2019::agenda')
		// 		->with('presentationId', '');
		// });

		Route::get('/cms/agenda', function()
		{
			$app = $this->app;
			$presentationId = Session::get('presentationId', '');
			$PresentationManagerService = $app->make('Mgallegos\DecimaOpenCms\OpenCms\Services\PresentationManagement\PresentationManagementInterface');
			$OpenCmsManagerService = $app->make('ECSL2019OpenCmsManagementInterface');
			$presentationTitle = $presentationDescription = '';

			if(!empty($presentationId))
			{
				$Presentation = $PresentationManagerService->getPresentation($presentationId, 'ecsl2019');
				$presentationTitle = $Presentation->name;
				$presentationDescription = $Presentation->description;
			}
			// var_dump($PresentationManagerService->getPresentationsWithSpeaker(1, 15, true, 'ecsl2019', false));
			// var_dump($PresentationManagerService->getPresentationsWithSpeakerAndSchedule(1, 15, true, 'ecsl2019', false));
			// var_dump($OpenCmsManagerService->getUsersRegistrationData());die();

			return View::make('ecsl-2019::agenda')
				->with('presentationId', $presentationId)
				->with('ogTitle', $presentationTitle)
				->with('ogDescription', $presentationDescription)
				->with('presentationId', $presentationId)
				->with('usersData', $OpenCmsManagerService->getUsersRegistrationData())
				// ->with('presentations', $PresentationManagerService->getPresentationsWithSpeaker(1, 15, true, 'ecsl2019', false))
				->with('presentationsBySchedule', $PresentationManagerService->getPresentationsWithSpeakerAndSchedule(1, 29, true, 'ecsl2019', false));
		});

		Route::post('/cms/presentaciones', function()
		{
			$app = $this->app;

	    return GridEncoder::encodeRequestedData(new \Mgallegos\ECSL2019\Repositories\Presentation\EloquentPresentationGridRepository($app['db']), Request::all());
		});

		AdvancedRoute::controller('/cms/dashboard', 'Mgallegos\ECSL2019\Controllers\OpenCmsManager');
		AdvancedRoute::controller('/cms/inicio-with-data', 'Mgallegos\ECSL2019\Controllers\InicioManager');

		Route::post('/cms/get-users', function()
		{
			$app = $this->app;

			$OpenCmsManagerService = $app->make('Ecsl2019OpenCmsManagementInterface');

			return $OpenCmsManagerService->saoh01(Request::json()->all());
		});

		Route::post('/cms/post-card-touch', function()
		{
			$app = $this->app;

			$OpenCmsManagerService = $app->make('Ecsl2019OpenCmsManagementInterface');

			return $OpenCmsManagerService->saoh02(Request::json()->all());
		});

		Route::post('/cms/post-share-info', function()
		{
			$app = $this->app;

			$OpenCmsManagerService = $app->make('Ecsl2019OpenCmsManagementInterface');

			return $OpenCmsManagerService->saoh03(Request::json()->all());
		});

		// AdvancedRoute::controller('/cms/ecsl-2019', 'Mgallegos\ECSL2019\Controllers\GestorCms');

};

Route::group(['domain' => 'localhost'], $ecsl);
Route::group(['domain' => 'app.decimaerp.com'], $ecsl);
Route::group(['domain' => 'ecsl2019.softwarelibre.ca'], $ecsl);
