p4.turkeyumber.com
==================

Project 4, PHP framework + JavaScript

"Notes from the Road" is a blogging app for users who are taking a trip within the continental US. Users create 'trips' with a title, optional description, and optional cover image for the trip they took. Any user can see the list of trips that have been taken, but only logged in users can 'star' trips they like and add new trips and trip entries. The trip 'dashboard' shows the list of blog entries that the user has logged along the way; entries have geolocated city/state, a timestamp, and optional text and images. A US map highlights the states the user has traveled in during the trip.

Features:
-users can choose not to log in and can see a list of all trips that have been entered and their details
-users can log in to create trips and blog entries for that trip
-logged-in users can star trips and view their starred trips only on a separate page
-entries geolocate
-states traveled in automatically highlight on the US map in the dashboard
-entry text toggles open using an icon that appears when there is text to see
-entry title and text can be modified by the user who wrote it
-logged-in user author can add images to an entry 
-when there are entry images an entry icon appears, which links to a separate entry gallery page (sorry, I tried to make this work as a JS colorbox/fancybox display but couldn't get it to work by the due date)
-logged-in users can comment on blog entries

JS manages:
-toggle open/closed new entry dialog on dashboard page using icon above map
-toggle open/closed text block for each blog entry
-toggle open/closed modify dialog for each blog entry

