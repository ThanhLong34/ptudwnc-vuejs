<template>
   <div class="py-4 container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="row">
               <div class="col-lg-3 col-md-6 col-12">
                  <card
                     :title="statistics.category.title"
                     :value="statistics.category.value"
                     :iconClass="statistics.category.iconClass"
                     :iconBackground="statistics.category.iconBackground"
                     detail=""
                     directionReverse
                  ></card>
               </div>
               <div class="col-lg-3 col-md-6 col-12">
                  <card
                     :title="statistics.project.title"
                     :value="statistics.project.value"
                     :iconClass="statistics.project.iconClass"
                     :iconBackground="statistics.project.iconBackground"
                     detail=""
                     directionReverse
                  ></card>
               </div>
               <div class="col-lg-3 col-md-6 col-12">
                  <card
                     :title="statistics.customerAccount.title"
                     :value="statistics.customerAccount.value"
                     :iconClass="statistics.customerAccount.iconClass"
                     :iconBackground="statistics.customerAccount.iconBackground"
                     detail=""
                     directionReverse
                  ></card>
               </div>
               <div class="col-lg-3 col-md-6 col-12">
                  <card
                     :title="statistics.order.title"
                     :value="statistics.order.value"
                     :iconClass="statistics.order.iconClass"
                     :iconBackground="statistics.order.iconBackground"
                     detail=""
                     directionReverse
                  ></card>
               </div>
            </div>
            <div class="row">
               <div class="col-xl-6 mb-xl-0 mb-4">
                  <master-card />
               </div>
               <div class="col-xl-6">
                  <div class="row">
                     <div class="col-md-6">
                        <default-info-card
                           :classIcon="salary.classIcon"
                           :title="salary.title"
                           :desc="salary.desc"
                           :price="salary.price"
                        />
                     </div>
                     <div class="col-md-6">
                        <default-info-card
                           :classIcon="paypal.classIcon"
                           :title="paypal.title"
                           :desc="paypal.desc"
                           :price="paypal.price"
                        />
                     </div>
                  </div>
               </div>
            </div>
            <div class="row mt-4">
               <div class="col-lg-7 mb-lg">
                  <!-- line chart -->
                  <div class="card z-index-2">
                     <gradient-line-chart
                        title="Bi???u ????? t???ng ti???n nh???n ???????c"
                        detail1="t??ng 50%"
                        :detail2="`trong n??m ${new Date().getFullYear()}`"
                     />
                  </div>
               </div>
               <div class="col-lg-5">
                  <carousel />
               </div>
            </div>
         </div>
      </div>
   </div>
</template>
<script>
import * as API from "@/helpers/api.js";

import MasterCard from "@/examples/Cards/MasterCard.vue";
import DefaultInfoCard from "@/examples/Cards/DefaultInfoCard.vue";
import Card from "@/examples/Cards/Card.vue";
import GradientLineChart from "@/examples/Charts/GradientLineChart.vue";
import Carousel from "../examples/Carousel.vue";

import { ElMessage } from "element-plus";

const apiPath = process.env.VUE_APP_SERVER_PATH_API;

export default {
   name: "DashboardView",
   components: {
      Card,
      GradientLineChart,
      Carousel,
      MasterCard,
      DefaultInfoCard,
   },
   data() {
      return {
         statistics: {
            category: {
               title: "Danh m???c",
               value: "0",
               iconClass: "ni ni-collection",
               iconBackground: "bg-gradient-warning",
            },
            project: {
               title: "D??? ??n",
               value: "0",
               iconClass: "ni ni-app",
               iconBackground: "bg-gradient-info",
            },
            customerAccount: {
               title: "Kh??ch h??ng",
               value: "0",
               iconClass: "ni ni-badge",
               iconBackground: "bg-gradient-primary",
            },
            order: {
               title: "????n h??ng",
               value: "0",
               iconClass: "ni ni-delivery-fast",
               iconBackground: "bg-gradient-success",
            },
         },
         salary: {
            classIcon: "text-white fa-solid fa-landmark",
            title: "Ti???n l????ng",
            desc: "T????ng t??c",
            price: "20.000.000 VND",
         },
         paypal: {
            classIcon: "text-white fa-solid fa-sack-dollar",
            title: "Ti???n d??? ??n",
            desc: "T??? do",
            price: "100,000,000 VND",
         },
      };
   },
   methods: {
      getCategories() {
         return API.get(
            apiPath + "/category/get_list.php",
            {
               limit: 0,
               offset: 0,
            },
            (data) => {
               if (data.code === 1) {
                  this.statistics.category.value = `${data.data.length}`;
               } else if (data.code === 2) {
                  ElMessage({
                     message: "Kh??ng l???y ???????c d??? li???u danh m???c",
                     type: "error",
                  });
                  console.error(data.message);
               }
            }
         );
      },
      getProjects() {
         return API.get(
            apiPath + "/project/get_list.php",
            {
               limit: 0,
               offset: 0,
            },
            (data) => {
               if (data.code === 1) {
                  this.statistics.project.value = `${data.data.length}`;
               } else if (data.code === 2) {
                  ElMessage({
                     message: "Kh??ng l???y ???????c d??? li???u d??? ??n",
                     type: "error",
                  });
                  console.error(data.message);
               }
            }
         );
      },
      getCustomerAccounts() {
         return API.get(
            apiPath + "/customer_account/get_list.php",
            {
               limit: 0,
               offset: 0,
            },
            (data) => {
               if (data.code === 1) {
                  this.statistics.customerAccount.value = `${data.data.length}`;
               } else if (data.code === 2) {
                  ElMessage({
                     message: "Kh??ng l???y ???????c d??? li???u t??i kho???n kh??ch h??ng",
                     type: "error",
                  });
                  console.error(data.message);
               }
            }
         );
      },
      getOrders() {
         return API.get(
            apiPath + "/order/get_list.php",
            {
               limit: 0,
               offset: 0,
            },
            (data) => {
               if (data.code === 1) {
                  this.statistics.order.value = `${data.data.length}`;
                  this.paypal.price = data.data.reduce((total, order) => {
                     // ???? thanh to??n
                     if (+order.Status === 1) {
                        return +order.Total;
                     }
                     return 0;
                  }, 0);
                  this.paypal.price = this.paypal.price.toLocaleString(
                     "it-IT",
                     { style: "currency", currency: "VND" }
                  );
               } else if (data.code === 2) {
                  ElMessage({
                     message: "Kh??ng l???y ???????c d??? li???u ????n h??ng",
                     type: "error",
                  });
                  console.error(data.message);
               }
            }
         );
      },
   },
   created() {
      // this.getCategories();
      // this.getProjects();
      // this.getCustomerAccounts();
      // this.getOrders();
   },
};
</script>
