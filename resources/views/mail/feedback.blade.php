
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>NConnect Team</title>
        <link href="https://fonts.cdnfonts.com/css/helvetica-neue-9" rel="stylesheet">

        <style>
            :root{
                font-family: 'Helvetica Neue', sans-serif;
            }

            .padding-inline{
                padding-left: 195px;
                padding-right: 195px
            }
      
            @media only screen and (max-width: 600px) {
                .padding-inline{
                    padding-left: 35px;
                    padding-right: 35px
                }
            }
        


        </style>
    </head>
    <body  style="height:100vh;background-image: linear-gradient(187.16deg, #05a7E6  0.07%, #000011 51.65%, #007777 98.75%); overflow:hidden; margin-bottom: 20px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="padding-inline">
            <tr style="color: #ffffff; font-weight: 400;font-size: 16px">
                <td  style="padding: 80px 0 80px 0;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr style="margin-bottom: 70px">
                            <td class="img-container" align="center">
                                <p style="text-transform: uppercase;font-weight: 500;font-size: 24px;">Nconnect</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="margin-bottom: 24px">{{ $greeting }}</p>
                            </td>
                        </tr>
                        <tr >
                            <td  >
                                <p style="margin-bottom: 28px;">{{ $thank_you }}</p>
                            </td>
                        </tr>
                        <tr >
                            <td>
                                <a href="{{ $url }}" style="margin-bottom: 40px;text-align: left; cursor: pointer; background-color:#525;border-radius: 4px; line-height: 150%; padding: 7px 13px 7px 13px; text-decoration:none;display:inline-block;color: white;">{{ $buttonText }}</a>
                            </td>
                        </tr>
                        <tr >
                            <td  >
                                <p style="margin-bottom: 20px">{{ $hint }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td  >
                                <p style="font-style: italic;margin-bottom: 40px;color: #CCCCCC;text-decoration:none;display:block;">{{ $url }}</p>
                            </td>
                        </tr>
                        <tr >
                            <td  >
                                <p style="margin-bottom: 24px">{{ $any_problems }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td  class="btn-container" >
                                <p>{{ $regards }} Nconnect Team.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>