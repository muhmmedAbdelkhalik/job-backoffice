<?php

use App\Models\User;

test('create user will pass', function () {
    // Arrange
    $user = [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'password' => 'password',
        'role' => 'admin',
    ];

    // Act
    $result = User::create($user);

    // Assert
    expect($result->name)->toBe($user['name']);
    expect($result->email)->toBe($user['email']);
    expect($result->role)->toBe($user['role']);
});

test('create user will fail', function () {
    // Arrange
    $user = [
        'name' => '',
        'email' => 'john.doe@example.com',
    ];

    // Act
    try {
        $result = User::create($user);
        $failed = false;
    } catch (\Exception $e) {
        $result = $e;
        $failed = true;
    }

    // Assert
    expect($failed)->toBeTrue();
    expect(User::where('email', "john.doe@example.com")->exists())->toBeFalse();
});