# CD Starter
This is a graphical interface tool for creating countdown timers for emails.

# How to use
This countdown tool is created in PHP, and will require a production server that can run the latest version of PHP.
You will also need MAMP or some other localhost server software that can run PHP on your local machine to use the tool.
With that said, use the following instructions to use this tool:

1) Install and start up MAMP or an equivalent software.
2) Download this repo and unzip it into MAMP's htdocs folder.
3) Open the `countdowns` folder, make a copy of the `_01_Countdown_Base` folder, and rename it to something related to the countdown you want to make.
4) Open a web browser and navigate to the `dev` folder of the countdown you just created (e.g.: `http://localhost/cd_starter/countdowns/YOUR_COUNTDOWN/dev/`).
5) You should see the GUI tool ready to use!

Once you've created a countdown, you will need to follow these next steps to push it live:
1) Upload the entire `cd_starter` folder (excluding the `_01_Countdown_Base` if you want) to a folder in your your live server.
2) You can now use the URL of the `index.php` as the `src` attribute for the image in your email where you want the countdown to be. If you are using media queries, you can append `?mb=y` to the `src` of that image.
E.g.:
```
<img src="https://www.mycoolsite.com/countdowns/YOUR_COUNTDOWN/" width="700" alt="Ends in a few days on January 5th!">

-- or --

<img src="https://www.mycoolsite.com/countdowns/YOUR_COUNTDOWN/?mb=y" width="700" alt="Ends in a few days on January 5th!">
```
3) To create a new countdown, you can simply follow steps 3-5 above, and then you'll only need to upload the newly named countdown to the `countdowns` folder on your live server.

# Setting up a cronjob
Generating a countdown can take quite a bit of resources, and having hundreds or thousands of people try and access a countdown image at once can quickly bring down your server.
As such, in order to have your countdowns refreshed every couple of minutes automatically, you'll need to set up a cronjob.
You should set up a cron job to run the `cron.php` file in the `countdowns` folder every X minutes, where X is how often you want the countdowns to be refreshed.

# Countdown look and feel
By default, this countdown uses a base background image provided in the `_01_Countdown_Base` folder, and the SpaceMono from Google Fonts in the `assets/fonts` folder.

You can customize these as you see fit. I hope to make this easier in the future, but for now, you will need to customize these yourself.

To customize your font, do the following:
1) Find a (preferably) monospace font that you like and download to get the .TTF version (other font file formats may also work).
2) Save that font in the `assets/fonts/` folder.
3) Open the `generate_cd.php` file of the countdown whose font you wish to change and find the following lines (line 95):
```
// fonts
$space_mono = "../../assets/fonts/SpaceMono-Bold.ttf";
```
4) Replace `SpaceMono-Bold.ttf` with the name of the font you added in step (2) above.


To customize the background images, you can use the `countdown_base_assets.ai` file found in the folder of the countdown you are working on.
The instructions on how large to save each image and what to name them are listed in that file.

If you don't have access to Adobe Illustrator, you can use the following dimensions to save your files:
- Desktop 'zero' image (shown when the countdown is over) - `cd_dt_zero.png` (1203px x 264px)
- Mobile 'zero' image - `cd_mb_zero.png` (570px x 560px)

- Desktop 'fallback' image (shown in case there's an issue with generating the countdown) - `cd_dt_fallback.png` (1203px x 264px)
- Mobile 'fallback' image - `cd_mb_fallback.png` (570px x 560px)

- Desktop countdown background image (used as the background for the desktop version) - `dt_bg.png` (700px x 153px)
- Mobile countdown background image (used as the background for the mobile version) - `mb_bg.png` (400px x 394px)


# Credits
This project uses the `AnimGif` class from lunakid (https://github.com/lunakid/AnimGif).
