### Running

-   Run docker
-   Run mysql docker container: `make dev_db`
-   Copy `.env` from `.env.example` [don't need to change any db config if you ran db with `make dev_db`]
-   Migrate database: `make migrate`
-   Run server `make dev`
-   Open `localhost:8000` in browser

You can run tests by `make test`

### Importing products

-   You can configure import job as sync or async by `.env` [QUEUE_CONNECTION=sync or QUEUE_CONNECTION=database]
-   The queue is also configured, you have to run `php artisan queue:work` to process queue if you choose async method

Note: tests are not configured to run with `QUEUE_CONNECTION=database` yet

### Current workflow

-   Buyer registers and logs in

    -   Buyer can import product by uploading csv file
    -   Buyer can see his products after importing is done

-   Seller registers and logs in
    -   Seller can see all products by all buyers
    -   Seller can add and remove product to/from his cart
    -   Seller can place order for his cart
    -   Seller can see his orders
