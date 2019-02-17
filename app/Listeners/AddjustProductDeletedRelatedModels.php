<?php

namespace App\Listeners;

use App\Events\ProductWasDeleted;
use Illuminate\Database\QueryException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\File;

class AddjustProductDeletedRelatedModels
{
    const MAIN_STORAGE_PATH = 'images/modifications/main_storage/';
    const DELETED_STORAGE_PATH = 'images/modifications/deleted_storage/';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProductWasDeleed  $event
     * @return void
     */
    public function handle(ProductWasDeleted $event)
    {
        try{
            foreach($event->product->applyings as $applying){
                $applying->delete();
            };

            foreach($event->product->modifications as $modification){
                $photo = self::MAIN_STORAGE_PATH . $modification->getFileNameFromFileUrl();

                /*Because we using soft delete for modifications, we don't delete file permanently. All we do is just move it
                from main storage to temporary one ('deleted_storage')*/
                if(File::exists($photo)){
                    File::move($photo, self::DELETED_STORAGE_PATH . $modification->getFileNameFromFileUrl());
                }

                try {
                    $modification->delete();
                } catch(QueryException $e){
                    // ADD TO LOG????
                }
            }
        } catch(\Exception $e) {
            // ADD TO LOG????
        }
    }
}
