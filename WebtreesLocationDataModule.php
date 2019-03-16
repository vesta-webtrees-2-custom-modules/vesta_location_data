<?php

namespace Cissee\Webtrees\Module\WebtreesLocationData;

use Cissee\Webtrees\Hook\HookInterfaces\EmptyIndividualFactsTabExtender;
use Cissee\Webtrees\Hook\HookInterfaces\IndividualFactsTabExtenderInterface;
use Vesta\Hook\HookInterfaces\EmptyFunctionsPlace;
use Vesta\Hook\HookInterfaces\FunctionsPlaceInterface;
use Cissee\WebtreesExt\FormatPlaceAdditions;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Module\AbstractModule;
use Vesta\Model\PlaceStructure;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Location;

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
    return '2.0.0-alpha.5.1';
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

  //returns lat/lon in int format!
  protected function getLatLon($gedcomName) {
    $location = new Location($gedcomName);
    $latitude = $location->latitude();
    $longitude = $location->longitude();

    //wtf [0,0] are also regular coordinates
    if (($latitude != 0) && ($longitude != 0)) {
      return array($latitude, $longitude);
    }

    return null;
  }

  //HookInterface: FunctionsPlaceInterface
  public function hPlacesGetLatLon(PlaceStructure $place) {
    return $this->getLatLon($place->getGedcomName());
  }

  //we shouldn't have to provide this separately ... just use hPlacesGetLatLon directly in tab!
  public function hFactsTabGetFormatPlaceAdditions(PlaceStructure $place) {
    $ll = $this->getLatLon($place->getGedcomName());
    $tooltip = null;
    if ($ll != null) {
      $long = array_pop($ll);
      $lati = array_pop($ll);

      //shouldn't be necessary here, types expected to be integer already
      //$lati = trim(strtr($lati, "NSEW,�", " - -. ")); // S5,6789 ==> -5.6789
      //$long = trim(strtr($long, "NSEW,�", " - -. ")); // E3.456� ==> 3.456

      $tooltip = 'via location data';
      $ll = array($lati, $long);
    }

    return new FormatPlaceAdditions('', $ll, $tooltip, '', '');
  }

}
