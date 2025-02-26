$(document).ready(function() {
       // Hamburger menu toggle
       const hamburgerMenu = document.getElementById('hamburger-menu');
       const navbarNav = document.querySelector('.navbar-nav');
       
       hamburgerMenu.addEventListener('click', function(e) {
         e.preventDefault();
         navbarNav.classList.toggle('active');
       });
   
       // Search form toggle - FIXED
       const searchButton = document.getElementById('search-button');
       const searchForm = document.querySelector('.search-form');
       const searchBox = document.getElementById('search-box');
       
       searchButton.addEventListener('click', function(e) {
         e.preventDefault();
         searchForm.classList.toggle('active');
         if (searchForm.classList.contains('active')) {
           searchBox.focus();
         }
       });
   
       // Shopping cart toggle - FIXED
       const cartButton = document.getElementById('shopping-cart-button');
       const shoppingCart = document.querySelector('.shopping-cart');
       
       cartButton.addEventListener('click', function(e) {
         e.preventDefault();
         shoppingCart.classList.toggle('active');
         updateCartDisplay();
       });
   
       // Close menus when clicking outside
       document.addEventListener('click', function(e) {
         // Check for navbar
         if (!hamburgerMenu.contains(e.target) && !navbarNav.contains(e.target)) {
           navbarNav.classList.remove('active');
         }
         
         // Check for search form
         if (!searchButton.contains(e.target) && !searchForm.contains(e.target)) {
           searchForm.classList.remove('active');
         }
         
         // Check for shopping cart
         if (!cartButton.contains(e.target) && !shoppingCart.contains(e.target)) {
           shoppingCart.classList.remove('active');
         }
       });
   
       // Search functionality
       searchBox.addEventListener('input', function() {
         const searchTerm = this.value.toLowerCase();
         const productCards = document.querySelectorAll('.product-card');
         
         productCards.forEach(card => {
           const productName = card.querySelector('h3').textContent.toLowerCase();
           if (productName.includes(searchTerm)) {
             card.style.display = 'flex';
           } else {
             card.style.display = 'none';
           }
         });
       });
   
       // Add to cart functionality
       const addToCartButtons = document.querySelectorAll('.product-card button');
       const cartItemsContainer = document.querySelector('.cart-items-container');
       const cartTotalAmount = document.getElementById('cart-total-amount');
       const emptyCartMessage = document.querySelector('.empty-cart');
       
       addToCartButtons.forEach(button => {
         button.addEventListener('click', function() {
           const card = this.closest('.product-card');
           const productName = card.querySelector('h3').textContent;
           const productPrice = card.querySelector('p').textContent;
           const productImg = card.querySelector('img').getAttribute('src');
           
           // Create cart item
           const cartItem = document.createElement('div');
           cartItem.className = 'cart-item';
           cartItem.innerHTML = `
             <img src="${productImg}" alt="${productName}">
             <div class="item-detail">
               <h3>${productName}</h3>
               <div class="item-price">${productPrice}</div>
             </div>
             <i data-feather="trash-2" class="remove-item"></i>
           `;
           
           // Add to cart
           cartItemsContainer.appendChild(cartItem);
           
           // Initialize the new feather icon
           feather.replace();
           
           // Bind remove event to the new button
           cartItem.querySelector('.remove-item').addEventListener('click', function() {
             cartItem.remove();
             updateCartDisplay();
             toastr.warning('Product removed from cart');
           });
           
           // Update total
           updateCartDisplay();
           
           // Show notification
           toastr.success('Product added to cart!');
           
           // Show the cart
           shoppingCart.classList.add('active');
         });
       });
   
       // Function to update cart display
       function updateCartDisplay() {
         const cartItems = document.querySelectorAll('.cart-item');
         
         // Show/hide empty cart message
         if (cartItems.length === 0) {
           emptyCartMessage.style.display = 'block';
         } else {
           emptyCartMessage.style.display = 'none';
         }
         
         // Calculate total
         let total = 0;
         cartItems.forEach(item => {
           const priceText = item.querySelector('.item-price').textContent;
           const price = parseInt(priceText.replace(/\D/g, ''));
           total += price;
         });
         
         // Update total display
         cartTotalAmount.textContent = 'Rp ' + total.toLocaleString();
       }
   
       // Initialize cart
       updateCartDisplay();
       
       // Product slider functionality  
       window.moveSlide = function(direction) {
         const productContainer = document.querySelector('.product-container');
         const productCards = document.querySelectorAll('.product-card');
         const cardWidth = productCards[0].offsetWidth;
         const visibleCards = 4;
         
         // Get current position
         let currentTransform = window.getComputedStyle(productContainer).getPropertyValue('transform');
         let currentX = currentTransform !== 'none' ? 
           parseInt(currentTransform.split(',')[4]) : 0;
         
         // Calculate new position
         let newPosition = currentX + (direction * (cardWidth * visibleCards));
         
         // Set limits
         const minPosition = -(cardWidth * (productCards.length - visibleCards));
         newPosition = Math.min(0, Math.max(newPosition, minPosition));
         
         // Apply new position
         productContainer.style.transform = `translateX(${newPosition}px)`;
       };
       
       // Checkout button event
       const checkoutBtn = document.getElementById('checkout-btn');
       checkoutBtn.addEventListener('click', function() {
         const cartItems = document.querySelectorAll('.cart-item');
         if (cartItems.length > 0) {
           toastr.success('Thank you for your purchase!');
           
           // Clear cart
           cartItemsContainer.innerHTML = '';
           updateCartDisplay();
         } else {
           toastr.error('Your cart is empty!');
         }
       });
     });
   