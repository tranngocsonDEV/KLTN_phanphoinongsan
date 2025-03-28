<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <title>Xác thực</title>
</head>

<body>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>reCAPTCHA Form</title>
        <style>
            /* Căn giữa toàn bộ nội dung trong trang */
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                /* Chiều cao toàn trang */
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #f8f9fa;
            }

            .container {
                text-align: center;
                background: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .error {
                color: red;
                font-weight: bold;
                margin-bottom: 20px;
            }
        </style>
    </head>

    <div class="d-flex text-align">

        <form id="captcha-form" action="../php/verify_recaptcha.php" method="POST">
            <div class="g-recaptcha" data-sitekey="6LflLZMqAAAAAN41n2mo9kSnC-z5JiGcCJuSb9kx" data-callback="onSubmit">
            </div>

            <button type="submit" id="submit-button" style="display:none;">Xác thực</button>
        </form>
    </div>

    <script>
        // Hàm callback được gọi khi reCAPTCHA hoàn thành
        function onSubmit() {
            var recaptchaResponse = document.querySelector('[name="g-recaptcha-response"]').value;
            if (recaptchaResponse) {
                document.getElementById('captcha-form').submit();
            } else {
                alert('Vui lòng hoàn thành CAPTCHA.');
            }
        }
        grecaptcha.ready(function () {
            grecaptcha.execute().catch(function (error) {
                console.error("reCAPTCHA Error:", error);
            });
        });


    </script>
</body>

</html>