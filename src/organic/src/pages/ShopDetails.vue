<template>
   <div class="shop-details">
      <TopPage :currentPage="'Chi tiết sản phẩm'" />
      <div class="shop-details-content">
         <div class="shop-details-product">
            <div class="grid wide">
               <div class="row">
                  <div class="col l-6 m-12 s-12">
                     <!-- product image -->
                     <div class="shop-details-product-img">
                        <div>
                           <!-- <img
                              src="@/assets/images/shop_details/exp.png"
                              alt="product image"
                           /> -->
                           <swiper
                              :modules="[Thumbs, Navigation]"
                              :thumbs="{ swiper: thumbsSwiper }"
                              watch-slides-progress
                              navigation
                           >
                              <swiper-slide>
                                 <img
                                    src="@/assets/images/shop_details/exp.png"
                                    alt="product image"
                                 />
                              </swiper-slide>
                              <swiper-slide>
                                 <img
                                    src="@/assets/images/shop_details/exp.png"
                                    alt="product image"
                                 />
                              </swiper-slide>
                              <swiper-slide>
                                 <img
                                    src="@/assets/images/shop_details/exp.png"
                                    alt="product image"
                                 />
                              </swiper-slide>
                           </swiper>
                        </div>
                        <button-icon>
                           <i class="fa-regular fa-heart"></i>
                        </button-icon>
                     </div>
                  </div>
                  <div class="col l-6 m-12 s-12">
                     <!-- product information -->
                     <div class="shop-details-product-info">
                        <h4 class="shop-details-product-name">
                           Veggan Egg Fresh
                        </h4>
                        <div class="shop-details-product-rating">
                           <div class="shop-details-product-rating-stars">
                              <i class="fa-solid fa-star active"></i>
                              <i class="fa-solid fa-star active"></i>
                              <i class="fa-solid fa-star active"></i>
                              <i class="fa-solid fa-star active"></i>
                              <i class="fa-regular fa-star"></i>
                           </div>
                           <div class="shop-details-product-rating-total">
                              &lpar;1 đánh giá&rpar;
                           </div>
                        </div>
                        <p class="shop-details-product-price">
                           <span class="shop-details-product-price-old"
                              >200.000đ</span
                           >
                           <span class="shop-details-product-price-new"
                              >180.000đ
                              <span class="shop-details-product-unit"
                                 >/ Kg</span
                              ></span
                           >
                        </p>
                        <p class="shop-details-product-desc">
                           Sumptuous, filling, and temptingly healthy, our Biona
                           Organic Granola with Wild Berries is just the thing
                           to get you out of bed. The goodness of rolled
                           wholegrain oats are combined.
                        </p>
                        <p class="shop-details-product-category">
                           DANH MỤC: <span>Rau củ</span>
                        </p>
                        <div class="shop-details-product-ctrl">
                           <div class="shop-details-product-ctrl-quantity">
                              <button
                                 class="shop-details-product-ctrl-sub-btn"
                                 @click="handleSubQuantity"
                              >
                                 &minus;
                              </button>
                              <span>{{ info.quantity }}</span>
                              <button
                                 class="shop-details-product-ctrl-add-btn"
                                 @click="handleAddQuantity"
                              >
                                 &plus;
                              </button>
                           </div>
                           <div class="shop-details-product-ctrl-other">
                              <button-v-2
                                 class="shop-details-product-ctrl-addtocart-btn"
                              >
                                 Thêm vào giỏ
                                 <i class="fa-solid fa-cart-plus"></i>
                              </button-v-2>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="shop-details-desc-and-rev">
            <div class="grid wide">
               <div class="row">
                  <div class="col l-12 m-12 s-12">
                     <div class="shop-details-desc-and-rev-tabs">
                        <button
                           :class="{
                              'shop-details-desc-and-rev-tabs-btn': true,
                              active: tab === 'description',
                           }"
                           @click="tab = 'description'"
                        >
                           Thông tin sản phẩm
                        </button>
                        <button
                           :class="{
                              'shop-details-desc-and-rev-tabs-btn': true,
                              active: tab === 'review',
                           }"
                           @click="tab = 'review'"
                        >
                           Đánh giá của khách hàng
                        </button>
                     </div>
                  </div>
                  <div class="col l-9 m-12 s-12">
                     <div class="shop-details-desc-and-rev-box">
                        <ProductDescription v-show="tab === 'description'" />
                        <ProductReview v-show="tab === 'review'" />
                     </div>
                  </div>
                  <div class="col l-3 m-12 s-12"></div>
               </div>
            </div>
         </div>
         <div class="shop-details-related">
            <div class="grid wide">
               <div class="row">
                  <div class="col l-12 m-12 s-12">
                     <div class="shop-details-related-title">
                        <p>HOÀN TOÀN TỰ NHIÊN</p>
                        <h5>Sản phẩm khác</h5>
                     </div>
                  </div>
                  <div class="col l-12 m-12 s-12">
                     <div>
                        <swiper
                           :speed="600"
                           :slides-per-view="3"
                           :loop="true"
                           :spaceBetween="25"
                           :autoplay="{
                              delay: 2000,
                              disableOnInteraction: false,
                              pauseOnMouseEnter: true,
                           }"
                           :breakpoints="{
                              0: {
                                 slidesPerView: 1,
                              },
                              740: {
                                 slidesPerView: 2,
                              },
                              1024: {
                                 slidesPerView: 3,
                              },
                           }"
                           :modules="modulesSwiper"
                        >
                           <swiper-slide
                              v-for="(item, index) in productsRelated"
                              :key="index"
                           >
                              <ProductV2 :product="item" />
                           </swiper-slide>
                        </swiper>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
/* eslint-disable */
import TopPage from "@/components/TopPage.vue";
import ButtonV2 from "@/components/ButtonV2.vue";
import ButtonIcon from "@/components/ButtonIcon.vue";
import ProductDescription from "@/components/ProductDescription.vue";
import ProductReview from "@/components/ProductReview.vue";
import ProductV2 from "@/components/ProductV2.vue";

//#region Slider Swiper
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";
// import required modules
import { Autoplay, Thumbs, Navigation } from "swiper";
//#endregion

import { ref, reactive, onMounted } from "vue";

export default {
   name: "ShopDetailsPage",
   components: {
      TopPage,
      ButtonV2,
      ButtonIcon,
      ProductDescription,
      ProductReview,
      ProductV2,
      Swiper,
      SwiperSlide,
   },
   setup() {
      const info = reactive({
         quantity: 1,
      });
      const tab = ref("description");
      const modulesSwiper = [Autoplay];

      const thumbsSwiper = ref(null);
      const setThumbsSwiper = (swiper) => {
         thumbsSwiper.value = swiper;
      };

      const productsRelated = reactive([
         {
            category: "Fresh",
            image: "exp.png",
            name: "Vegan Egg Replacer",
            priceOld: "280.00",
            priceNew: "180.00",
            description:
               "Apparently we had reached a great height in the atmosphere.",
            star: 4,
         },
         {
            category: "Fresh",
            image: "exp1.png",
            name: "Vegan Egg Replacer",
            priceOld: "280.00",
            priceNew: "180.00",
            description:
               "Apparently we had reached a great height in the atmosphere.",
            star: 5,
         },
         {
            category: "Fresh",
            image: "exp2.png",
            name: "Vegan Egg Replacer",
            priceOld: "280.00",
            priceNew: "180.00",
            description:
               "Apparently we had reached a great height in the atmosphere.",
            star: 4,
         },
         {
            category: "Fresh",
            image: "exp3.png",
            name: "Vegan Egg Replacer",
            priceOld: "280.00",
            priceNew: "180.00",
            description:
               "Apparently we had reached a great height in the atmosphere.",
            star: 5,
         },
      ]);

      function handleSubQuantity() {
         if (info.quantity > 1) {
            info.quantity -= 1;
         }
      }

      function handleAddQuantity() {
         if (info.quantity < 99) {
            info.quantity += 1;
         }
      }

      return {
         info,
         tab,
         modulesSwiper,
         handleSubQuantity,
         handleAddQuantity,
         productsRelated,
         Navigation,
         Thumbs,
         thumbsSwiper,
         setThumbsSwiper,
      };
   },
};
</script>

<style lang="scss" scoped>
@use "@/assets/scss/variables.scss" as *;

.shop-details-product {
   padding: 100px 0;

   &-img {
      position: relative;
      user-select: none;
      .button-icon {
         position: absolute;
         top: 0;
         right: 0;
         z-index: 2;
      }
   }

   &-info {
      padding-left: 20px;
      color: $darkTextColor;
   }

   &-name {
      font-size: 42px;
   }

   &-rating {
      margin: 22px 0;
      display: flex;
      align-items: flex-end;
      color: #828282;

      &-stars {
         i {
            font-size: 16px;
            display: inline-block;

            &.active {
               color: #ffa900;
            }
         }

         i + i {
            margin-left: 2px;
         }
      }

      &-total {
         font-size: 18px;
         color: $darkTextColor;
         margin-left: 8px;
      }
   }

   &-price {
      font-weight: 500;
      margin-bottom: 20px;

      &-old {
         font-size: 20px;
         color: #9299a3;
         text-decoration: line-through;
         margin-right: 10px;
      }

      &-new {
         font-size: 24px;
         font-weight: 700;
         color: #ff0404;
      }
   }

   &-unit {
      color: $primaryColor;
      font-weight: 500;
   }

   &-desc {
      font-size: 20px;
      line-height: 1.4;
      color: #656565;
      margin-bottom: 30px;
   }

   &-ctrl {
      display: flex;
      align-items: center;
      color: $darkTextColor;

      &-quantity {
         position: relative;
         padding: 3px 3px;
         border-radius: 20px;
         background-color: #f2f2f2;
         display: flex;
         align-items: center;
         justify-content: space-between;

         span {
            font-size: 20px;
            font-weight: 600;
            width: 62px;
            text-align: center;
         }
      }

      &-sub-btn,
      &-add-btn {
         width: 36px;
         height: 36px;
         line-height: 36px;
         border-radius: 50%;
         text-align: center;
         font-size: 26px;
         background-color: white;
         font-weight: 400;
         transition: all ease 0.4s;

         &:hover {
            background-color: $primaryColor;
            color: white;
         }
      }

      &-addtocart-btn {
         margin-left: 40px;
      }
   }

   &-category {
      margin-bottom: 30px;
      font-size: 16px;
      font-weight: 600;
      color: #474747;
      letter-spacing: 1px;

      span {
         color: $primaryColor;
         font-weight: 700;
         font-size: 18px;
         letter-spacing: unset;
      }
   }

   @media (max-width: $maxTablet) {
      &-img {
         margin-bottom: 80px;
      }
   }

   @media (max-width: 500px) {
      &-img {
         margin-bottom: 50px;
      }

      &-ctrl {
         align-items: flex-start;
         flex-direction: column;

         &-addtocart-btn {
            margin-left: 0;
            margin-top: 30px;
         }
      }

      &-category {
         margin-top: 40px;
      }
   }
}

.shop-details-desc-and-rev {
   padding: 20px 0;

   &-tabs {
      margin-bottom: 30px;
      background-color: rgba($primaryColor, 0.1);

      &-btn {
         padding: 16px 20px;
         font-size: 18px;
         text-transform: uppercase;
         transition: all ease 0.4s;
         background-color: transparent;

         &.active,
         &:hover {
            background-color: $primaryColor;
            color: white;
         }

         @media (max-width: $maxMobile) {
            width: 100%;
         }
      }
   }

   @media (max-width: $maxMobile) {
      padding: 0 0 20px;
   }
}

.shop-details-related {
   padding: 100px 0 50px;

   &-title {
      text-align: center;
      margin-bottom: 50px;

      p {
         color: $primaryColor;
         font-size: 18px;
         text-transform: uppercase;
         margin-bottom: 12px;
      }

      h5 {
         color: $darkTextColor;
         font-size: 38px;
         line-height: 1.2;
         font-weight: bold;
      }
   }
}
</style>
