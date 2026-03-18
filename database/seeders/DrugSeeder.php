<?php
namespace Database\Seeders;

use App\Models\Drug;
use App\Models\DrugRelation;
use App\Services\DrugService;
use App\Utils\GoogleTranslate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DrugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedMainDrugs();

        $priority = $this->command->ask('Choose priority: Dump from file - 1 | from site - 2', 1);

        $this->seedPsychiatrienet('antidepressants.json', 'switch_antidepressants', $priority);
        $this->seedPsychiatrienet('antipsychotics.json', 'switch_antipsychotics', $priority);
        $this->seedPsychiatrienet('moodstabilizers.json', 'combine_moodstabilizers', $priority);
        $this->seedStopAntidepressants($priority);
    }

    public function seedMainDrugs()
    {
        $data = json_decode(file_get_contents(storage_path('database/drugs.json')), true);

        foreach ($data as $item) {
            $drug = Drug::firstOrCreate(['name' => $item['primary_name']], [
                'description' => $item['description'],
            ]);

            foreach ($item['alias_name'] as $alias) {
                $drug->aliases()->firstOrCreate(['name' => $alias]);
            }
        }
    }

    public function seedPsychiatrienet($file, $type, $priority)
    {
        $urls = [
            'switch_antidepressants'  => 'https://psychiatrienet.nl/switchtabel/show?id=SwitchAntidepressants',
            'switch_antipsychotics'   => 'https://psychiatrienet.nl/switchtabel/show?id=SwitchAntipsychotics',
            'combine_moodstabilizers' => 'https://psychiatrienet.nl/switchtabel/show?id=CombiningMoodstabilizers',
        ];

        if (Storage::disk('local')->exists($file) and $priority == 1) {
            $data = Storage::disk('local')->get($file);

            foreach (json_decode($data, true) as $item) {
                $first_drug  = Drug::firstOrCreate(['name' => $item['primary_drug']]);
                $second_drug = Drug::firstOrCreate(['name' => $item['secondary_drug']]);

                DrugRelation::create([
                    'type'              => $item['type'],
                    'primary_drug_id'   => $first_drug->id,
                    'secondary_drug_id' => $second_drug->id,
                    'metadata'          => $item['metadata'],
                ]);
            }

            return;
        }

        $service      = new DrugService;
        $list         = $service->getListFromPsychiatrienet($urls[$type]);
        $storage      = [];
        $drug_records = [];

        foreach ($list['names_ru'] as $name) {
            $drug_records[] = Drug::firstOrCreate(['name' => $name]);
        }

        foreach ($list['names'] as $first_key => $first_drug) {
            $copy = $list['names'];
            foreach ($copy as $second_key => $second_drug) {
                if ($second_drug == $first_drug) {continue;}

                $pair = str_replace(['_', ' '], '-', strtolower($first_drug . '-' . $second_drug));
                if (! in_array($pair, $list['urls'])) {
                    $storage[] = [
                        'type'           => $type,
                        'primary_drug'   => $drug_records[$first_key]->name,
                        'secondary_drug' => $drug_records[$second_key]->name,
                        'metadata'       => [],
                    ];

                    DrugRelation::create([
                        'type'              => $type,
                        'primary_drug_id'   => $drug_records[$first_key]->id,
                        'secondary_drug_id' => $drug_records[$second_key]->id,
                        'metadata'          => [],
                    ]);

                    continue;
                }

                $drug_data = $service->getSwitchFromPsychiatrienet(strtolower($pair));

                $content1 = GoogleTranslate::translate('auto', 'uz', implode("\n", $drug_data[0]['data']));
                $content2 = GoogleTranslate::translate('auto', 'uz', implode("\n", $drug_data[1]['data']));
                $content3 = GoogleTranslate::translate('auto', 'uz', implode("\n", $drug_data[2]['data']));

                $storage[] = [
                    'type'           => $type,
                    'primary_drug'   => $drug_records[$first_key]->name,
                    'secondary_drug' => $drug_records[$second_key]->name,
                    'metadata'       => compact('content1', 'content2', 'content3'),
                ];

                DrugRelation::create([
                    'type'              => $type,
                    'primary_drug_id'   => $drug_records[$first_key]->id,
                    'secondary_drug_id' => $drug_records[$second_key]->id,
                    'metadata'          => compact('content1', 'content2', 'content3'),
                ]);
            }

            sleep(0.5);
        }

        Storage::disk('local')->put($file, json_encode($storage, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    public function seedStopAntidepressants($priority)
    {
        if (Storage::disk('local')->exists('stopantidepressants.json') and $priority == 1) {
            $data = Storage::disk('local')->get('stopantidepressants.json');

            foreach (json_decode($data, true) as $item) {
                $first_drug = Drug::firstOrCreate(['name' => $item['primary_drug']]);

                DrugRelation::create([
                    'type'            => 'stop_antidepressants',
                    'primary_drug_id' => $first_drug->id,
                    'metadata'        => $item['metadata'],
                ]);
            }

            return;
        }

        $service = new DrugService;
        $list    = $service->getListFromPsychiatrienet('https://psychiatrienet.nl/switchtabel/show?id=SwitchAntidepressants');
        $storage = [];

        foreach ($list['names'] as $key => $name) {
            $drug = Drug::firstOrCreate(['name' => $list['names_ru'][$key]]);
            $pair = strtolower('stop-' . $name);

            $data     = $service->getStopFromPsychiatrienet($pair);
            $content1 = GoogleTranslate::translate('auto', 'uz', implode("\n", $data['data']));

            $storage[] = [
                'primary_drug' => $drug->name,
                'metadata'     => compact('content1'),
            ];

            DrugRelation::create([
                'type'            => 'stop_antidepressants',
                'primary_drug_id' => $drug->id,
                'metadata'        => compact('content1'),
            ]);
        }

        Storage::disk('local')->put('stopantidepressants.json', json_encode($storage, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}
