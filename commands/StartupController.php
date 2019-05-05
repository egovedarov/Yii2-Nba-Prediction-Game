<?php

namespace app\commands;


use app\components\startup\NbaTeamNamesService;

class StartupController extends Controller
{
    public function actionLoadTeamNames(
        NbaTeamNamesService $nbaTeamNamesService
    )
    {
        $nbaTeamNamesService->loadTeamNames();
    }
}