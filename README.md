
# ⚶ Vesta Webtrees Location Data Provider (Webtrees 2 Custom Module)

This [webtrees](https://www.webtrees.net/) custom module provides (non-GEDCOM) location data collected via webtrees to other modules.
The project’s website is [cissee.de](https://cissee.de).

This is a webtrees 2.x module - It cannot be used with webtrees 1.x.

## Contents

* [Features](#features)
* [Download](#download)
* [Installation](#installation)
* [License](#license)

### Features<a name="features"/>

* Provides non-GEDCOM location data (map coordinates) collected via webtrees (Control panel > Map > Geographic data) to other modules.
Thus, users may migrate easily away e.g. from the original places module, without having to re-enter all location data.

### Download<a name="download"/>

* Current version: 2.0.3.10
* Based on and tested with webtrees 2.0.3. Cannot be used with webtrees 1.x. May not work with earlier 2.x versions!
* Requires the ⚶ Vesta Common module ('vesta_common').
* Download the zipped module, including all related modules, [here](https://cissee.de/vesta.latest.zip).
* Support, suggestions, feature requests: <ric@richard-cissee.de>
* Issues also via <https://github.com/vesta-webtrees-2-custom-modules/vesta_location_data/issues>

### Installation<a name="installation"/>

* Unzip the files and copy them to the modules_v3 folder of your webtrees installation. All related modules are included in the zip file. It's safe to overwrite the respective directories if they already exist (they are bundled with other custom modules as well), as long as other custom models using these dependencies are also upgraded to their respective latest versions.
* Enable the main module via Control Panel -> Modules -> Module Administration -> ⚶ Vesta Webtrees Location Data Provider.

### License<a name="license"/>

* **vesta_location_data: a webtrees custom module**
* Copyright (C) 2019 - 2020 Richard Cissée
* Derived from **webtrees** - Copyright (C) 2010 to 2019 webtrees development team.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
