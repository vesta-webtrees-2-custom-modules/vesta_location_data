<?php

namespace Cissee\Webtrees\Module\WebtreesLocationData;

use Cissee\Webtrees\Hook\HookInterfaces\EmptyIndividualFactsTabExtender;
use Cissee\Webtrees\Hook\HookInterfaces\IndividualFactsTabExtenderInterface;
use Cissee\WebtreesExt\FormatPlaceAdditions;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Location;
use Fisharebest\Webtrees\Module\AbstractModule;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Vesta\Hook\HookInterfaces\EmptyFunctionsPlace;
use Vesta\Hook\HookInterfaces\FunctionsPlaceInterface;
use Vesta\Model\MapCoordinates;
use Vesta\Model\PlaceStructure;
use Vesta\Model\Trace;

class WebtreesLocationDataModule extends AbstractModule implements ModuleCustomInterface, IndividualFactsTabExtenderInterface, FunctionsPlaceInterface {

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
    return '2.0.0-beta.4.1';
  }

  public function customModuleLatestVersionUrl(): string {
    return 'https://cissee.de';
  }

  public function customModuleSupportUrl(): string {
    return 'https://cissee.de';
  }

  public function title(): string {
    return $this->vesta . ' ' . I18N::translate('Vesta Webtrees Location Data Provider');
  }

  public function description(): string {
    return I18N::translate('A module providing (non-GEDCOM-based) webtrees location data to other modules.');
  }

  /**
   * Where does this module store its resources
   *
   * @return string
   */
  public function resourcesFolder(): string {
    return __DIR__ . '/resources/';
  }

  /**
   * Additional/updated translations.
   *
   * @param string $language
   *
   * @return string[]
   */
  public function customTranslations(string $language): array {
    //TODO
    return [];
  }

  protected function getLatLon($gedcomName) {
    $location = new Location($gedcomName);
    $latitude = $location->latitude();
    $longitude = $location->longitude();

    //wtf webtrees: 0.0; 0.0 are valid coordinates, why do you use them for 'unknown'?
    if (($latitude !== 0.0) && ($longitude !== 0.0)) {
      return array($latitude, $longitude);
    }

    return null;
  }

  //HookInterface: FunctionsPlaceInterface  
  public function plac2Map(PlaceStructure $ps): ?MapCoordinates {
    $location = new Location($ps->getGedcomName());
    $latitude = $location->latitude();
    $longitude = $location->longitude();

    //wtf webtrees: 0.0; 0.0 are valid coordinates, why do you use them for 'unknown'?
    if (($latitude !== 0.0) && ($longitude !== 0.0)) {
      return new MapCoordinates(''.$latitude, ''.$longitude, new Trace(I18N::translate('map coordinates via Webtrees Location Data module (mapping outside GEDCOM)')));
    }
    
    return null;
  }
}
