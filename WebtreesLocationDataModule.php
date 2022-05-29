<?php

namespace Cissee\Webtrees\Module\WebtreesLocationData;

use Cissee\WebtreesExt\Module\ModuleMetaInterface;
use Cissee\WebtreesExt\Module\ModuleMetaTrait;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Module\AbstractModule;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\PlaceLocation;
use Vesta\CommonI18N;
use Vesta\Hook\HookInterfaces\EmptyFunctionsPlace;
use Vesta\Hook\HookInterfaces\FunctionsPlaceInterface;
use Vesta\Model\MapCoordinates;
use Vesta\Model\PlaceStructure;
use Vesta\Model\Trace;
use Vesta\ModuleI18N;
use Vesta\VestaModuleCustomTrait;

class WebtreesLocationDataModule extends AbstractModule implements
    ModuleCustomInterface, 
    ModuleMetaInterface, 
    //IndividualFactsTabExtenderInterface, //huh? no
    FunctionsPlaceInterface {

    use ModuleCustomTrait,
        ModuleMetaTrait,
        VestaModuleCustomTrait {
        VestaModuleCustomTrait::customTranslations insteadof ModuleCustomTrait;
        ModuleMetaTrait::customModuleVersion insteadof ModuleCustomTrait;
        ModuleMetaTrait::customModuleLatestVersion insteadof ModuleCustomTrait;
    }

    //use EmptyIndividualFactsTabExtender;
    use EmptyFunctionsPlace;

    private $vesta;

    public function __construct() {
        $this->vesta = json_decode('"\u26B6"');
    }

    public function customModuleAuthorName(): string {
        return 'Richard Cissée';
    }

    public function customModuleMetaDatasJson(): string {
        return file_get_contents(__DIR__ . '/metadata.json');
    }

    public function customModuleLatestMetaDatasJsonUrl(): string {
        return 'https://raw.githubusercontent.com/vesta-webtrees-2-custom-modules/vesta_location_data/master/metadata.json';
    }

    public function customModuleSupportUrl(): string {
        return 'https://cissee.de';
    }

    public function title(): string {
        $title = CommonI18N::titleVestaLocationData();
        return $this->vesta . ' ' . $title;
    }

    public function description(): string {
        $description = I18N::translate('A module providing (non-GEDCOM-based) webtrees location data to other modules.');
        if (!$this->isEnabled()) {
            $description = ModuleI18N::translate($this, $description);
        }
        return $description;
    }

    public function resourcesFolder(): string {
        return __DIR__ . '/resources/';
    }

    protected function getLatLon($gedcomName) {
        $location = new PlaceLocation($gedcomName);
        $latitude = $location->latitude();
        $longitude = $location->longitude();

        if (($latitude !== null) && ($longitude !== null)) {
            return array($latitude, $longitude);
        }

        return null;
    }

    //HookInterface: FunctionsPlaceInterface  
    public function plac2map(PlaceStructure $ps): ?MapCoordinates {
        $location = new PlaceLocation($ps->getGedcomName());
        $latitude = $location->latitude();
        $longitude = $location->longitude();

        if (($latitude !== null) && ($longitude !== null)) {
            return new MapCoordinates('' . $latitude, '' . $longitude, new Trace(I18N::translate('map coordinates via Webtrees Location Data module (mapping outside GEDCOM)')));
        }
        return null;
    }

}
