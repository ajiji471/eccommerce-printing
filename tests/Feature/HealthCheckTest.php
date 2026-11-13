<?php

it('melaporkan kesehatan aplikasi pada /up', function () {
    $this->get('/up')->assertOk();
});
