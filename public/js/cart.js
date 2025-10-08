// import { createApp } from 'vue';
// import axios from 'axios';

// const app = createApp({
//     mounted() {
//         const buttons = document.querySelectorAll('.add-to-cart-btn');

//         buttons.forEach(btn => {
//             btn.addEventListener('click', async (e) => {
//                 e.preventDefault();

//                 const productId = btn.getAttribute('data-id');

//                 console.log('Adding product to cart:', productId);

//                 try {
//                     const response = await axios.post('/api/cart', {
//                         product_id: productId
//                     });

//                     alert(`✅ ${response.data.message || 'Product added to cart!'}`);
//                 } catch (error) {
//                     console.error(error);
//                     alert('❌ Failed to add product to cart');
//                 }
//             });
//         });
//     }
// });

// app.mount('#app');
