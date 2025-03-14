<?php

/**
 * Define a test case.
 *
 * @param string $description The test description
 * @param callable $closure The test implementation
 * @return void
 */
function test(string $description, callable $closure): void {}

/**
 * Create a new expectation.
 *
 * @param mixed $value The value to expect against
 * @return object The expectation object
 */
function expect($value): object {
    return new class($value) {
        private $value;
        
        public function __construct($value) {
            $this->value = $value;
        }
        
        /**
         * Assert that the value is an instance of the given class.
         * 
         * @param string $class
         * @return self
         */
        public function toBeInstanceOf(string $class): self { return $this; }
        
        /**
         * Assert that the value equals the expected value.
         * Works with arrays, objects, and scalar values.
         * 
         * @param mixed $expected Any type of value (array, object, string, etc.)
         * @return self
         */
        public function toBe($expected): self { return $this; }
        
        /**
         * Assert that the value has the given key.
         * 
         * @param string $key
         * @return self
         */
        public function toHaveKey(string $key): self { return $this; }
        
        /**
         * Chain expectations.
         * 
         * @param mixed $value
         * @return object
         */
        public function and($value): object { return expect($value); }
    };
}

/**
 * Define a hook to be run before each test.
 *
 * @param callable $closure The hook implementation
 * @return void
 */
function beforeEach(callable $closure): void {}

/**
 * Define a hook to be run after each test.
 *
 * @param callable $closure The hook implementation
 * @return void
 */
function afterEach(callable $closure): void {}

/**
 * Define a hook to be run before all tests.
 *
 * @param callable $closure The hook implementation
 * @return void
 */
function beforeAll(callable $closure): void {}

/**
 * Define a hook to be run after all tests.
 *
 * @param callable $closure The hook implementation
 * @return void
 */
function afterAll(callable $closure): void {}

/**
 * Define a dataset to be used in tests.
 *
 * @param array $dataset The dataset
 * @return void
 */
function dataset(array $dataset): void {}

/**
 * Use the given traits in the test case.
 *
 * @param string|array $traits The traits to use
 * @return void
 */
function uses($traits): void {}
