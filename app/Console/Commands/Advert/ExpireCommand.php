<?php


namespace App\Console\Commands\Advert;


use App\UseCases\Adverts\AdvertService;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Advert;
class ExpireCommand extends Command
{
    protected $signature = 'advert:expire';


    private $service;

    public function __construct(AdvertService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle(): bool
    {

        $success = true;
        foreach (Advert::active()->where('expired_at' . '<' . Carbon::now())->cursor() as $advert) {


            try {
                $this->service->expire($advert->id);
            } catch (\DomainException $e) {
                $this->error($e->getMessage());
                $success = false;
            }
            return $success;
        }
    }
}