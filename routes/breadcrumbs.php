<?php // routes/breadcrumbs.php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Support\Facades\Route;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Settings
Breadcrumbs::for('settings', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Systems', route('settings'));
});

// Departments
Breadcrumbs::for('departments.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Departments', route('departments.index'));
});

Breadcrumbs::for('departments.create', function (BreadcrumbTrail $trail) {
    $trail->parent('departments.index');
    $trail->push('Add Department', route('departments.create'));
});

Breadcrumbs::for('departments.edit', function (BreadcrumbTrail $trail, $department) {
    $trail->parent('departments.index');
    $trail->push('Edit Department', route('departments.edit', $department));
});

Breadcrumbs::for('departments.show', function (BreadcrumbTrail $trail, $department) {
    $trail->parent('departments.index');
    $trail->push('View Department', route('departments.show', $department));
});

// Roles
Breadcrumbs::for('roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Roles', route('roles.index'));
});

Breadcrumbs::for('roles.create', function (BreadcrumbTrail $trail) {
    $trail->parent('roles.index');
    $trail->push('Add Role', route('roles.create'));
});

Breadcrumbs::for('roles.edit', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('roles.index');
    $trail->push('Edit Role', route('roles.edit', $role));
});

Breadcrumbs::for('roles.show', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('roles.index');
    $trail->push('View Role', route('roles.show', $role));
});

// User Role Permissions
Breadcrumbs::for('user-role-permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('User Role Permissions', route('user-role-permissions.index'));
});

Breadcrumbs::for('user-role-permissions.create', function (BreadcrumbTrail $trail) {
    $trail->parent('user-role-permissions.index');
    $trail->push('Add Permission', route('user-role-permissions.create'));
});

Breadcrumbs::for('user-role-permissions.edit', function (BreadcrumbTrail $trail, $user_role_permission) {
    $trail->parent('user-role-permissions.index');
    $trail->push('Edit Permission', route('user-role-permissions.edit', $user_role_permission));
});

Breadcrumbs::for('user-role-permissions.show', function (BreadcrumbTrail $trail, $user_role_permission) {
    $trail->parent('user-role-permissions.index');
    $trail->push('View Permission', route('user-role-permissions.show', $user_role_permission));
});

// Tabs
Breadcrumbs::for('tabs.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Tabs', route('tabs.index'));
});

Breadcrumbs::for('tabs.create', function (BreadcrumbTrail $trail) {
    $trail->parent('tabs.index');
    $trail->push('Add Tab', route('tabs.create'));
});

Breadcrumbs::for('tabs.edit', function (BreadcrumbTrail $trail, $tab) {
    $trail->parent('tabs.index');
    $trail->push('Edit Tab', route('tabs.edit', $tab));
});

Breadcrumbs::for('tabs.show', function (BreadcrumbTrail $trail, $tab) {
    $trail->parent('tabs.index');
    $trail->push('View Tab', route('tabs.show', $tab));
});

// Student Invoices
Breadcrumbs::for('student_invoices.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Student Invoices', route('student_invoices.index'));
});
