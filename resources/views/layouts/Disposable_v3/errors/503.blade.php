<!DOCTYPE html>
<html>
  <head>
    <title>@lang('errors.503.title')</title>
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
        font-size: 72px;
        margin-bottom: 24px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="content">
        <div class="title">
          @lang('errors.503.message')
        </div>
      </div>
    </div>
  </body>
</html>
