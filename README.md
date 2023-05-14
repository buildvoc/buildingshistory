# buildingshistory
### Introduction
Interactive map for users to explore old buildings using the following field data. See working [demo](https://buildingshistory.co.uk/#17.71/52.958902/-1.537071/-160.1/65) 
![image](https://github.com/buildvoc/buildingshistory/assets/76884997/17c0f007-f83a-4df6-a783-e4ea211cbb6a)

* ### Routes 
Currently using [Active Travel Infrastructure Platform (ATIP)](https://github.com/acteng/atip) exported in geojson [see examples ](https://github.com/buildvoc/buildingshistory/tree/main/geojson-examples)
* ### Photos 
Images of buildings collected on routes with geo referencing metadata (EXIF) [see examples ](https://github.com/buildvoc/buildingshistory/tree/main/photos-examples) 
hoping to deploy [Mappics](http://pics.antodippo.com/) in the near future for photo management 
* ### Camera Field of View
Metadata used when photos is captured showing angle/direction of lens
[Leaflet.GeotagPhoto](https://github.com/nypl-spacetime/Leaflet.GeotagPhoto)
* ### Indoor
This uses historical images during a time period, to illustrate how rooms were used, also in future indoor navigation. [see examples ](https://github.com/buildvoc/buildingshistory/tree/main/indoor-examples) https://indoorequal.org/#map=19.89/51.3677055/-2.2023699&level=0
* ### GNSS Hardware / Apps
Low cost /DIY GNSS system configuration for capturing field data
* [Galaxy Tab Active 3 Tablet ](https://www.samsung.com/uk/tablets/others/galaxy-tab-active3-8-inch-black-64gb-lte-sm-t575nzkaeea/) £150 second hand, use serial port to connect to GNSS receiver
* [Columbus P-7 Pro HD GNSS receiver](https://www.columbus-gps.de/produkte/columbus-p7-pro-gnss-empfaenger) £150 for maximum position accuracy by using two frequency bands at the same time, a new generation of position accuracy in the submeter range is achieved. 
* [Harry's Camper ](https://apps.apple.com/us/app/harrys-camper/id952167017) £8.99 use this to capture waypoints, routes, supports a lot of external GNSS receivers
The road book included records trips automatically - even with the app in background. Other than common trackers, data is kept private and is stored on your phone only. For trips recorded, not only the route but daily distances, stations you stayed overnight and dates and other information is automatically derived. (this is a great app and Harry provides excellent support)
* [RTK camera](https://play.google.com/store/apps/details?id=at.redcatch.rtkcamera&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1) Subscription still under development Android only is an All-In-One NTRIP and camera app, to take centimeter accurate geotagged photos and logging the path you've walked.(still testing, my GNSS receiver doesn't support RTK corrections)
