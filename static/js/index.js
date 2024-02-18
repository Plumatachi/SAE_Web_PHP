const config = {
    individualItem: '.album-item', // class of individual item
    individualItem2: '.album2-item', // class of individual item
    carouselWidth: 1900, // in px
    carouselId: '#album-rotator', // carousel selector
    carouselId2: '#album2-rotator', // carousel selector
    carouselHolderId: '#album-rotator-holder', // 
    carouselHolderId2: '#album2-rotator-holder', // 
}

document.addEventListener("DOMContentLoaded", function(e) {
    // Get items
    const el = document.querySelector(config.individualItem);
    const el2 = document.querySelector(config.individualItem2);
    const elWidth = parseFloat(window.getComputedStyle(el).width) + parseFloat(window.getComputedStyle(el).marginLeft) + parseFloat(window.getComputedStyle(el).marginRight);
    const el2Width = parseFloat(window.getComputedStyle(el2).width) + parseFloat(window.getComputedStyle(el2).marginLeft) + parseFloat(window.getComputedStyle(el2).marginRight);
    // Track carousel
    let mousedown = false;
    let initialPosition = 0;
    let selectedItem;
    let currentDelta1 = 0;
    let currentDelta2 = 0;

    document.querySelectorAll(config.carouselId).forEach(function(item) { 
        item.style.width = `${config.carouselWidth}px`;
    });

    document.querySelectorAll(config.carouselId2).forEach(function(item) {
        item.style.width = `${config.carouselWidth}px`;
    });
    
    document.querySelectorAll(config.carouselId).forEach(function(item) {
        item.addEventListener('pointerdown', function(e) {
            mousedown = true;
            selectedItem = item;
            initialPosition = e.pageX;
            currentDelta1 = parseFloat(item.querySelector(config.carouselHolderId).style.transform.split('translateX(')[1]) || 0;
        }); 
    });
    
    document.querySelectorAll(config.carouselId2).forEach(function(item) {
        item.addEventListener('pointerdown', function(e) {
            mousedown = true;
            selectedItem = item;
            initialPosition = e.pageX;
            currentDelta2 = parseFloat(item.querySelector(config.carouselHolderId2).style.transform.split('translateX(')[1]) || 0;
        }); 
    });

    const scrollCarousel = function(change, currentDelta1, selectedItem) {
        let numberThatFit = Math.floor(config.carouselWidth / elWidth);
        let newDelta = currentDelta1 + change;
        let elLength = selectedItem.querySelectorAll(config.individualItem).length - numberThatFit;
        if(newDelta <= 0 && newDelta >= -elWidth * elLength) {
            selectedItem.querySelector(config.carouselHolderId).style.transform = `translateX(${newDelta}px)`;
        } else {
            if(newDelta <= -elWidth * elLength) {
                console.log(-elWidth * elLength);
                selectedItem.querySelector(config.carouselHolderId).style.transform = `translateX(${-elWidth * elLength}px)`;
            } else if(newDelta >= 0) {
                selectedItem.querySelector(config.carouselHolderId).style.transform = `translateX(0px)`;
            }
        }
    }

    const scrollCarousel2 = function(change, currentDelta2, selectedItem) {
        let numberThatFit2 = Math.floor(config.carouselWidth / el2Width);
        let newDelta = currentDelta2 + change;
        let el2Length = selectedItem.querySelectorAll(config.individualItem2).length - numberThatFit2;
        if(newDelta <= 0 && newDelta >= -el2Width * el2Length) {
            console.log('delta',newDelta);
            selectedItem.querySelector(config.carouselHolderId2).style.transform = `translateX(${newDelta}px)`;
        } else {
            if(newDelta <= -el2Width * el2Length) {
                console.log(-el2Width * el2Length);
                selectedItem.querySelector(config.carouselHolderId2).style.transform = `translateX(${-el2Width * el2Length}px)`;
            } else if(newDelta >= 0) {
                selectedItem.querySelector(config.carouselHolderId2).style.transform = `translateX(0px)`;
            }
        }
    }

    let rotator = document.getElementById('album-rotator-holder');
    rotator.addEventListener('pointermove', function(e) {
        if(mousedown == true && typeof selectedItem !== "undefined") {
            let change = -(initialPosition - e.pageX);
            scrollCarousel(change, currentDelta1, selectedItem);
            document.querySelectorAll(`${config.carouselId} a`).forEach(function(item) {
                item.style.pointerEvents = 'none';
            });
        }
    });

    let rotator2 = document.getElementById('album2-rotator-holder');
    rotator2.addEventListener('pointermove', function(e) {
        if(mousedown == true && typeof selectedItem !== "undefined") {
            let change = -(initialPosition - e.pageX);
            scrollCarousel2(change, currentDelta2, selectedItem);
            document.querySelectorAll(`${config.carouselId2} a`).forEach(function(item) {
                item.style.pointerEvents = 'none';
            });
        }
    });

    ['pointerup', 'mouseleave'].forEach(function(item) {
        document.body.addEventListener(item, function(e) {
            selectedItem = undefined;
            document.querySelectorAll(`${config.carouselId} a, ${config.carouselId2} a`).forEach(function(item) {
                item.style.pointerEvents = 'all';
            });
        });
    });
});