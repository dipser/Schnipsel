var intersection = function(arr1, arr2) { // Example: intersection([1,2,3], [2,3,4,5]) => [2, 3]
    return arr1.filter(value => arr2.includes(value));
}
