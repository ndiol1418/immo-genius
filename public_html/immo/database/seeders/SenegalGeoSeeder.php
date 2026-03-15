<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\Departement;
use App\Models\Commune;
use Illuminate\Database\Seeder;

class SenegalGeoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'Dakar' => [
                'Dakar'       => ['Dakar Plateau','Grand Dakar','Biscuiterie','Gueule Tapée-Fass-Colobane','HLM','Médina','Ngor','Ouakam','Yoff','Almadies','Liberté','Mermoz-Sacré-Cœur','Patte d\'Oie','Parcelles Assainies'],
                'Pikine'      => ['Pikine Nord','Pikine Est','Pikine Ouest','Dalifort','Djida Thiaroye Kao','Guinaw Rail Nord','Guinaw Rail Sud','Thiaroye sur Mer','Thiaroye-Gare','Tivaouane Diacksao','Yeumbeul Nord','Yeumbeul Sud','Diamaguene Sicap Mbao','Mbao','Keur Massar'],
                'Guédiawaye'  => ['Golf Sud','Médina Gounass','Ndiareme Limamoulaye','Sam Notaire','Wakhinane Nimzatt'],
                'Rufisque'    => ['Rufisque Nord','Rufisque Est','Rufisque Ouest','Bargny','Diamniadio','Sangalkam','Tivaouane Peulh-Niaga','Yene'],
            ],
            'Thiès' => [
                'Thiès'       => ['Thiès Nord','Thiès Est','Thiès Ouest','Fandène','Keur Moussa','Ndieyène Sirakh','Noto Gouye Diama','Pout','Tassette','Thiénaba'],
                'Mbour'       => ['Mbour','Joal-Fadiouth','Nguékhokh','Popenguine-Ndayane','Fissel','Malicounda','Ngaparou','Sindia','Somone','Thiadiaye'],
                'Tivaouane'   => ['Tivaouane','Méouane','Méckhé','Mont-Rolland','Niakhène','Pambal','Pire Goureye','Thilmakha'],
            ],
            'Saint-Louis' => [
                'Saint-Louis' => ['Saint-Louis','Rao','Gandon','Fass-Ngom-Coki','Mpal','Ndiébène Gandiol','Sakal'],
                'Dagana'      => ['Dagana','Richard-Toll','Bokhol','Rosso-Sénégal','Mbane','Ngnith','Ronkh','Thiagar'],
                'Podor'       => ['Podor','Aoré','Bodé Lao','Boké Dialloubé','Démette','Dolol','Fanaye','Gamadji Saré','Garly','Guédé Chantier','Guédé Village','Médina Ndiathbé','Mboumba','Nabadji Civol','Ndioum','Ogo','Orkadière','Pété','Thillé Boubacar','Walaldé','Cas-Cas'],
            ],
            'Louga' => [
                'Louga'       => ['Louga','Coki','Dahra','Kébémer','Thiamène','Mbédiène','Nguer Malal','Sakal'],
                'Linguère'    => ['Linguère','Barkedji','Dodji','Gassane','Labgar','Mbeuleukhé','Ouarkhokh','Ranérou'],
                'Kébémer'     => ['Kébémer','Darou Mousti','Guéoul','Ndande'],
            ],
            'Fatick' => [
                'Fatick'      => ['Fatick','Diarrère','Dioffior','Fimela','Gossas','Ndiendieng','Niakhar','Patar','Tattaguine'],
                'Foundiougne' => ['Foundiougne','Bassoul','Djilor','Kagnout','Loul Sessène','Niodior','Toubacouta'],
                'Gossas'      => ['Gossas','Colobane','Mbar'],
            ],
            'Kaolack' => [
                'Kaolack'     => ['Kaolack','Gandiaye','Guinguinéo','Kahone','Ndoffane','Nioro du Rip'],
                'Guinguinéo'  => ['Guinguinéo','Dya','Keur Baka','Ngélou','Ngoth'],
                'Nioro du Rip'=> ['Nioro du Rip','Gainth Kaye','Keur Madiabel','Médina Sabakh','Paos Koto','Porokhane','Sibassor','Wack Ngouna'],
            ],
            'Diourbel' => [
                'Diourbel'    => ['Diourbel','Ndoulo','Ngoye','Touba Mosquée'],
                'Bambey'      => ['Bambey','Baba Garage','Gawane','Lambaye','Ndindy','Ngogom','Patar Lia','Réfane'],
                'Mbacké'      => ['Mbacké','Kaël','Ndame','Nguer Malal','Sadio','Taif','Touba'],
            ],
            'Ziguinchor' => [
                'Ziguinchor'  => ['Ziguinchor','Adéane','Boutoupa-Camaracounda','Enampor','Niaguis','Nyassia'],
                'Bignona'     => ['Bignona','Diégoune','Djibidione','Kataba I','Karthiack','Mangagoulack','Mlomp','Oulampane','Sindian','Tendouck','Thionck-Essyl'],
                'Oussouye'    => ['Oussouye','Cachouane','Cabrousse','Diembéring','Loudia-Ouolof','Santhiaba Manjaque'],
            ],
            'Kolda' => [
                'Kolda'                 => ['Kolda','Bagadadji','Dioulacounda','Dabo','Guiro Yéro Bocar','Mampatim','Médina Chérif','Médina El Hadj','Ndorna','Sakar','Tankanto Escale','Velingara Ferlo'],
                'Vélingara'             => ['Vélingara','Bonconto','Diaobé-Kabendou','Diédou','Fafacourou','Kandia','Kounkané','Médina Gounass','Ndorna','Pakour','Sinthiang Coundara'],
                'Médina Yoro Foulah'    => ['Médina Yoro Foulah','Badion','Fafacourou','Güiro Yéro Bocar','Ndorna','Niaming','Pata','Sala'],
            ],
            'Tambacounda' => [
                'Tambacounda' => ['Tambacounda','Dialacoto','Gouloumbou','Koumpentoum','Makacolibantang','Missirah','Niani','Sinthiou Malème'],
                'Bakel'       => ['Bakel','Bélé','Boynguel Bamba','Diawara','Gabou','Gathiary','Gouroumba','Kéniéba','Kidira','Moudéry','Sinthiou Fissa','Tomboronkoto'],
                'Goudiry'     => ['Goudiry','Bala','Boynguel Bamba','Dianké Makha','Kénioto','Koulor','Sinthiou Mamadou Boubou'],
                'Koumpentoum' => ['Koumpentoum','Kahène','Makacolibantang','Maka Coulibantang','Ndame','Payar','Sinthiou Malème'],
            ],
            'Kédougou' => [
                'Kédougou'    => ['Kédougou','Bandafassi','Fongolimbi','Khossanto','Ninéfescha','Sadatou','Salémata'],
                'Saraya'      => ['Saraya','Bembou','Khossanto','Médina Baffé','Tomboronkoto'],
                'Salemata'    => ['Salemata','Dakateli','Ethiolo','Kévoye'],
            ],
            'Matam' => [
                'Matam'           => ['Matam','Agnam Civol','Dabia','Kanel','Ogo','Ourossogui','Semme','Thialgou','Thilogne'],
                'Kanel'           => ['Kanel','Aouré','Bakel','Bokiladji','Dabia','Hamady Ounaré','Orkadiéré','Ranérou','Sinthiou Bamambé-Banadji','Wouro Sidy','Yaféra'],
                'Ranérou-Ferlo'   => ['Ranérou','Lougré Thioly','Oudalaye'],
            ],
            'Kaffrine' => [
                'Kaffrine'        => ['Kaffrine','Birkelane','Diamagadio','Gniby','Kathiote','Koungheul','Mabo','Nganda','Ida Mouride'],
                'Birkelane'       => ['Birkelane','Diamagadio','Maffèye','Ndiognick','Ngothie'],
                'Koungheul'       => ['Koungheul','Fass','Ida Mouride','Kahi','Lour Escale','Médina Sabakh','Missirah Wadène','Ndiokhène','Saly Escale','Touba Mbél'],
                'Malem-Hodar'     => ['Malem-Hodar','Darou Minam II','Keur Ndiaye Lo','Lour Escale','Missirah Wadène','Ngathie Naoudé','Ndiokhène','Saly Escale'],
            ],
            'Sédhiou' => [
                'Sédhiou'         => ['Sédhiou','Bambali','Bona','Diende','Djibidione','Goudomp','Marsassoum','Niagha'],
                'Bounkiling'      => ['Bounkiling','Boghal','Diacounda','Faoune','Kandion Mangana','Karantaba','Kerewane','Konkia','Niaming','Simbandi Balante','Simbandi Brassou','Tankon'],
                'Goudomp'         => ['Goudomp','Baghere','Basséré','Djibanar','Kabrousse','Karantaba','Niagha','Sakar','Simbandi Balante'],
            ],
        ];

        foreach ($data as $regionName => $departements) {
            $region = Region::firstOrCreate(['name' => $regionName], ['status' => 1]);

            foreach ($departements as $deptName => $communes) {
                $dept = Departement::firstOrCreate(
                    ['name' => $deptName],
                    ['status' => 1, 'region_id' => $region->id]
                );
                // Met à jour region_id si déjà existant sans région
                if (!$dept->region_id) {
                    $dept->update(['region_id' => $region->id]);
                }

                foreach ($communes as $communeName) {
                    Commune::firstOrCreate(
                        ['name' => $communeName, 'departement_id' => $dept->id],
                        ['status' => 1]
                    );
                }
            }
        }
    }
}
