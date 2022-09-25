<?php

namespace App\Console\Commands;

use RoachPHP\Roach;
use App\Spiders\WirelessSpider;
use Illuminate\Console\Command;

class ScrapWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ScrapWebsite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //getting whole set of data
        $items = Roach::collectSpider(WirelessSpider::class);

        //converting to array
        $data = [];
        foreach ($items as $item) {
            $data[] = $item->all();
        }

        //Sorting of the table
        usort($data, function ($item1, $item2) {
            return (int)str_replace('£', '', $item2['price']) <=> (int)str_replace('£', '', $item1['price']);
        });

        //displaying result if exist
        if ($data) {
            $this->line(json_encode($data,JSON_UNESCAPED_UNICODE));
        } else {
            $this->line('Data not found');
        }

        return 0;
    }
}
