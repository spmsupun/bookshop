#Bookshop

###Installing

Backend\
`git@github.com:spmsupun/bookshop.git` \
`composer install`\
`php bin/console doctrine:database:create`\
`php bin/console doctrine:schema:update --force`\
`php bin/console doctrine:fixtures:load`

Frontend\
`yarn install`\
`yarn encore dev`

`php bin/console server:start`

###Test

`php bin/phpunit`

###Note:
Recommended environment is linux (Ubuntu).
Cart's books store using a unique id. when user close the browser, cart item will be lose.
