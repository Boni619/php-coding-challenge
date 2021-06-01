<?php

namespace App\Service;

interface ApiServiceInterface
{
    public function getCategories();

    public function productByCategory($cat_id);

    public function cartStore($formData);

    public function userCartDetail();

    public function getProducts();

    public function productStore($formData);
}
