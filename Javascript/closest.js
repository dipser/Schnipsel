// http://stackoverflow.com/questions/15329167/closest-ancestor-matching-selector-using-native-dom
function closest(elem, selector) {
   var matchesSelector = elem.matches || elem.webkitMatchesSelector || elem.mozMatchesSelector || elem.msMatchesSelector;
    while (elem) {
        if (matchesSelector.bind(elem)(selector)) {
            return elem;
        } else {
            elem = elem.parentElement;
        }
    }
    return false;
}
//closest(currentDOMNode, '.item');
