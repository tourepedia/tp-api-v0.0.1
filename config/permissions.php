<?php

/**
 * This file holds the permissions used into application. We are not storing the permissions into the database
 * as permissions are more specific to the application level. Storing the application would required creation of
 * permission into the database and implementation into the application. At the end of the day, each permission has
 * to be implemented into the application else creation of permission doesn't make any sense.
 *
 * But we have to store the relationship of permissions with the users and roles in the database. So when one makes
 * changes to any existing permission key (which ideally should not happen after permission's implementation), same
 * should be done in the database too.
 */

return [
    // store the user/role permission for all the entities in the database like locations, tags, roles, tags etc.
    "user" => [
        "can_see_admin_dashboard" => [
            "description" => "Should allowed to see the Dashboard. All the team members should be given this access."
        ],
        "can_see_users" => [
            "description" => "Should allow to see the list of users",
            "prerequisites" => ["can_see_admin_dashboard"]
        ],
        "can_create_users" => [
            "description" => "Should allow to create new users.",
            "prerequisites" => ["can_see_users"]
        ],
        "can_see_roles" => [
            "description" => "Should allow to see the list of roles.",
            "prerequisites" => ["can_see_admin_dashboard"]
        ],
        "can_create_roles" => [
            "description" => "Should allow to create new roles.",
            "prerequisites" => ["can_see_roles"]
        ],
        "can_update_permissions" => [
            "description" => "Should allow to update the permissions of any user",
            "prerequisites" => ["can_see_users", "can_see_roles"]
        ]
    ]
];
