#  Փոխարժեքների ծառայություն

Այս ծրագիրը վերցնում է տարադրամի փոխարժեքները [frankfurter.dev](https://www.frankfurter.dev)-ի API-ից և ցույց է տալիս դրանք՝ հիմք ընդունելով ընտրված հիմնական արժույթը։

## Հնարավորություններ

- Սպասարկում է API միջոցով փոխարժեքներ
- Հնարավորություն է տալիս փոխել հիմնական արժույթը
- Գրանցում է օգտվողի IP, սարքի տեսակ (User-Agent) և ժամ
- Տվյալները պահվում են MySQL-ում

## Տեխնոլոգիաներ

- PHP (OOP + MVC)
- MySQL
- API՝ [frankfurter.dev](https://www.frankfurter.dev)

## Հրահանգներ

1. Ստեղծել MySQL բազա՝ `currency` անունով
2. Ավելացնել աղյուսակ՝ `access_log` (ավտոմատ կստեղծվի)
3. Կոնֆիգուրաացնել `app/configs/config.php`՝ ըստ ձեր տվյալների

## շ
Ծանուցում՝ մենք չենք օգտագործում առանձին models/access_log.php, քանի որ արդեն մենք ֆունկցիայի տեսքով 
գրված է Databas.php ֆայլում(ֆւնկցիայի տեսքով):

```php
define('HOST_NAME', 'localhost');
define('HOST_USERNAME', 'root');
define('HOST_PASSWORD', '');
