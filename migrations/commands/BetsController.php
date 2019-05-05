<?php

namespace app\commands;

use app\components\BetsService;

class BetsController extends Controller
{
    /**
     * @param BetsService $betsService
     */
    public function actionUpdateBets(
        BetsService $betsService
    )
    {
        $betsService->updateBets();
    }
}