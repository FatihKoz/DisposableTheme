<!DOCTYPE html>
<html>
  <head>
    <title>500 | Server Error</title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Lato:wght@400;800">
    <style>
      html, body {
        height: 100%;
      }

      body {
        margin: 0;
        padding: 0;
        width: 100%;
        color: darkgoldenrod;
        background-color: black;
        display: table;
        font-weight: 400;
        font-family: 'Lato', sans-serif;
      }

      .container {
        text-align: center;
        display: table-cell;
        vertical-align: middle;
      }

      .content {
        text-align: center;
        display: inline-block;
      }

      .title {
        font-size: 48px;
        margin-bottom: 24px;
      }

      .infotext {
        font-size: 24px;
        margin-bottom: 12px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="content">
        <div class="title">
          Something went terribly wrong !
          <br>
          <span style="color: darkorange; font-size: 36px;"> 500 | Server Error</span>
          <br>
          <span style="color: darkred; font-size: 20px;">If you are a regular user, please inform website administrators</span>
          <br>
        </div>
        <div class="infotext" style="text-align: left">
          What an administrator should do now;<br>
          <br>
          &bull; Check laravel logs for error details<br>
          &bull; Enable APP_DEBUG and re-visit same page<br>
          <br>
          With more information in hand;<br>
          <br>
          &bull; Either ask for help with all required details<br>
          &bull; Or try fixing it personally<br>
          <br>
          <span style="color: darkred; font-size: 20px;"><b>Sharing an image of this page for help will not work, never did :(</b></span>
          <br><br>
          <a style="font-size: 20px; text-decoration: none" href="https://docs.phpvms.net/help">phpVMS Docs | Getting Help</a>
        </div>
      </div>
    </div>
  </body>
</html>
