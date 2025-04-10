

document.addEventListener('contextmenu', event => event.preventDefault());
    document.onkeydown = function(e) {
    if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && ['I', 'J', 'C'].includes(e.key))) {
        return false;
    }
};
