<?php

namespace Cissee\Webtrees\Module\WebtreesLocationData;

use Cissee\Webtrees\Hook\HookInterfaces\EmptyIndividualFactsTabExtender;
use Cissee\Webtrees\Hook\HookInterfaces\IndividualFactsTabExtenderInterface;
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
  IndividualFactsTabExtenderInterface, 
  FunctionsPlaceInterface {

  use ModuleCustomTrait, VestaModuleCustomTrait {
    VestaModuleCustomTrait::customTranslations insteadof ModuleCustomTrait;
    VestaModuleCustomTrait::customModuleLatestVersion insteadof ModuleCustomTrait;
  }
  
  use EmptyIndividualFactsTabExtender;
  use EmptyFunctionsPlace;

  private $vesta;

  public function __construct() {
    $this->vesta = json_decode('"\u26B6"');
  }

  public function customModuleAuthorName(): string {
    return 'Richard Cissée';
  }

  public function customModuleVersion(): string {
    return file_get_contents(__DIR__ . '/latest-version.txt');
  }

  public function customModuleLatestVersionUrl(): string {
    return 'https://raw.githubusercontent.com/vesta-webtrees-2-custom-modules/vesta_location_data/master/latest-version.txt';
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

    //wtf webtrees: 0.0; 0.0 are valid coordinates, why do you use them for 'unknown'?
    if (($latitude !== 0.0) && ($longitude !== 0.0)) {
      return array($latitude, $longitude);
    }

    return null;
  }

  //HookInterface: FunctionsPlaceInterface  
  public function plac2map(PlaceStructure $ps): ?MapCoordinates {
    $location = new PlaceLocation($ps->getGedcomName());
    $latitude = $location->latitude();
    $longitude = $location->longitude();
    
    //wtf webtrees: 0.0; 0.0 are valid coordinates, why do you use them for 'unknown'?
    if (($latitude !== 0.0) && ($longitude !== 0.0)) {
      return new MapCoordinates(''.$latitude, ''.$longitude, new Trace(I18N::translate('map coordinates via Webtrees Location Data module (mapping outside GEDCOM)')));
    }
    
    return null;
  }
}
