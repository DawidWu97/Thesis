<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission'     => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role'           => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'              => 'Title',
            'title_helper'       => ' ',
            'permissions'        => 'Permissions',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user'           => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Name',
            'name_helper'              => ' ',
            'email'                    => 'Email',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Password',
            'password_helper'          => ' ',
            'roles'                    => 'Roles',
            'roles_helper'             => ' ',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'approved'                 => 'Approved',
            'approved_helper'          => ' ',
            'username'                 => 'Username',
            'username_helper'          => ' ',
        ],
    ],
    'serviceStation' => [
        'title'          => 'Service Stations',
        'title_singular' => 'Service Station',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'user'               => 'User',
            'user_helper'        => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'phone'              => 'Phone',
            'phone_helper'       => ' ',
            'photo'              => 'Photo',
            'photo_helper'       => ' ',
            'city'               => 'City',
            'city_helper'        => ' ',
            'street'             => 'Street',
            'street_helper'      => ' ',
            'postcode'           => 'Postcode',
            'postcode_helper'    => ' ',
            'approved'           => 'Approved',
            'approved_helper'    => ' ',
            'created_by'         => 'Created By',
            'created_by_helper'  => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'opening'            => 'Opening',
            'opening_helper'     => ' ',
            'closing'            => 'Closing',
            'closing_helper'     => ' ',
            'workplaces'         => 'Workplaces',
            'workplaces_helper'  => ' ',
        ],
    ],
    'userAlert'      => [
        'title'          => 'User Alerts',
        'title_singular' => 'User Alert',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'alert_text'        => 'Alert Text',
            'alert_text_helper' => ' ',
            'alert_link'        => 'Alert Link',
            'alert_link_helper' => ' ',
            'user'              => 'Users',
            'user_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
        ],
    ],
    'service'        => [
        'title'          => 'Services',
        'title_singular' => 'Service',
    ],
    'car'            => [
        'title'          => 'Cars',
        'title_singular' => 'Car',
        'fields'         => [
            'id'                    => 'ID',
            'id_helper'             => ' ',
            'brand'                 => 'Brand',
            'brand_helper'          => ' ',
            'model'                 => 'Model',
            'model_helper'          => ' ',
            'engine'                => 'Engine',
            'engine_helper'         => ' ',
            'vin'                   => 'Vin',
            'vin_helper'            => ' ',
            'plates'                => 'Plates',
            'plates_helper'         => ' ',
            'user'                  => 'User',
            'user_helper'           => ' ',
            'created_at'            => 'Created at',
            'created_at_helper'     => ' ',
            'updated_at'            => 'Updated at',
            'updated_at_helper'     => ' ',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => ' ',
            'created_by'            => 'Created By',
            'created_by_helper'     => ' ',
            'bought_mileage'        => 'Bought Mileage',
            'bought_mileage_helper' => ' ',
            'bought_at'             => 'Bought at',
            'bought_at_helper'      => ' ',
        ],
    ],
    'repair'         => [
        'title'          => 'Repairs',
        'title_singular' => 'Repair',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'car'                      => 'Car',
            'car_helper'               => ' ',
            'station'                  => 'Station',
            'station_helper'           => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'mileage'                  => 'Mileage',
            'mileage_helper'           => ' ',
            'finished_at'              => 'Finished at',
            'finished_at_helper'       => ' ',
            'approved'                 => 'Approved',
            'approved_helper'          => ' ',
            'description'              => 'Description',
            'description_helper'       => ' ',
            'customer_comments'        => 'Customer Comments',
            'customer_comments_helper' => ' ',
            'started_at'               => 'Started at',
            'started_at_helper'        => ' ',
            'canceled'                 => 'Canceled',
            'canceled_helper'          => ' ',
            'calculated_finish'        => 'Calculated Finish',
            'calculated_finish_helper' => ' ',
        ],
    ],
    'part'           => [
        'title'          => 'Parts',
        'title_singular' => 'Part',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'price'             => 'Price',
            'price_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'task'              => 'Task',
            'task_helper'       => ' ',
        ],
    ],
    'task'           => [
        'title'          => 'Tasks',
        'title_singular' => 'Task',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'repair'            => 'Repair',
            'repair_helper'     => ' ',
            'duration'          => 'Duration',
            'duration_helper'   => ' ',
        ],
    ],
    'upcoming'       => [
        'title'          => 'Upcomings',
        'title_singular' => 'Upcoming',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'car'                => 'Car',
            'car_helper'         => ' ',
            'mileage'            => 'Mileage',
            'mileage_helper'     => ' ',
            'repair_at'          => 'Repair at',
            'repair_at_helper'   => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
        ],
    ],
];
