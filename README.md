# BE Delicious
A WordPress-based bookmarks manager like Del.icio.us

This is a quickly developed MVP which is why it relies on ACF and WPForms for some functionality. I might revisit this in the future and build everything directly in the theme so there are no plugin dependencies, but I wanted to test & iterate on the functionality first.

## Setup

1. Install the theme
2. Install and activate WPForms plugin, WPForms Post Submission addon, and Advanced Custom Fields Pro
3. Go to WPForms > Tools > Import and import the [wpforms export file](https://github.com/billerickson/BE-Delicious/blob/master/wpforms-form-export-09-27-2024.json) inside the theme.
4. Go to Site Options and select your imported form for the "Publish" form location.
5. Create and publish a page using whatever URL you want to visit when publishing new links. No content is required. Set the page template to "Publish". This will display the WPForms form if the user is logged in, or redirect them to the login page.
6. [Optional] Go to Appearance > Block Areas, create a new one called "Sidebar" and assign it to the "Sidebar" location. Add the Tag Cloud block, the publish it.
