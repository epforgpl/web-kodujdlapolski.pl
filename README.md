# web-kodujdlapolski.pl
Theme dla Wordpress obsługujący http://kodujdlapolski.pl

## Wymagania

Moduły PHP:
- php5-gd
- php5-curl

Dyrektywa vhost:
```
AllowOverride All
Options +FollowSymLinks +SymLinksIfOwnerMatch
```

Uprawnienia:
ustawić prawa do zapisu dla `www-data` do `wp-content`.

Wordpress + pluginy: 
- testowane na wersji WP 4.4.2 
- Advanced Custom Fields Pro 5.3.4 
- Category Order and Taxonomy Terms Order 1.4.7
- Duplikuj wpis 2.6
- Members 1.1.1
- Require Featured Image 1.2.1
- Username Changer 2.0.5
- WP-Mail-SMTP 0.9.5 
- Members 0.2.4
- Yoast SEO 3.0.7 
- WPML Multilingual CMS **3.3.5** (w wyższej bug)
- WPML String Translation **2.3.5** (w wyższej bug)

Konfiguracja:
- ustawienia bazy danych w wp-config.php 
- ustawienia mail w ustawieniach wtyczki WP-Mail-SMTP
