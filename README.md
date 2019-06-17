CONFIGURATION
-------------

### Clone this repository

```bash
git clone https://github.com/batuoc263/vnpt_mds
```

### Make directory 
```mkdir uploads```
or
```New>New Folder>uploads```

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=vnpt_mds',
    'username' => 'root',
    'password' => 'password',
    'charset' => 'utf8',
];
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
- Refer to the README in the `tests` directory for information specific to basic application tests.



