<template>
   <div class="py-4 container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card mb-4">
               <div class="card-header pb-2">
                  <h6>✅ Chọn tiêu chí tìm kiếm ✅ Tìm kiếm ✅ Lọc dữ liệu</h6>
               </div>
               <div class="card-body px-4 pt-0 pb-4">
                  <div class="row">
                     <div class="col-8">
                        <div class="search-wrap">
                           <argon-input
                              ref="searchCodeRef"
                              type="search"
                              icon="fas fa-search"
                              iconDir="left"
                              placeholder="Nhập mã đơn hàng..."
                              v-model="searchInfo.code"
                           />
                           <argon-button
                              color="primary"
                              size="sm"
                              variant="gradient"
                              @click="search"
                           >
                              Tìm kiếm
                           </argon-button>
                           <argon-button
                              color="dark"
                              size="sm"
                              class="reload-button"
                              @click="reload"
                           >
                              Tải lại
                           </argon-button>
                        </div>
                     </div>
                     <div class="col-4">
                        <div class="selection-wrap">
                           <el-select
                              v-model="filterInfo.status"
                              filterable
                              placeholder="Chọn trạng thái"
                              @change="filtering"
                           >
                              <el-option
                                 v-for="item in status"
                                 :key="item.id"
                                 :label="item.name"
                                 :value="item.id"
                              />
                           </el-select>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-12"></div>
         </div>
      </div>
   </div>
</template>

<script>
import ArgonInput from "@/components/ArgonInput.vue";
import ArgonButton from "@/components/ArgonButton.vue";

export default {
   name: "OrderView",
   components: {
      ArgonInput,
      ArgonButton,
   },
   data() {
      return {
         status: [
            { id: 0, name: "Đang chờ duyệt" },
            { id: 1, name: "Đã duyệt" },
            { id: 2, name: "Đã từ chối" },
         ],
         searchInfo: {
            code: "",
         },
         filterInfo: {
            status: "",
         },
      };
   },
   methods: {
      reloadTableData() {
         this.$refs.tableRef.reload();
      },
      reload() {
         this.$refs.tableRef.choosePage(1);
         this.$refs.searchCodeRef.setValue("");

         this.searchInfo.code = "";
         this.filterInfo.status = "";
      },
      search() {
         if (this.searchInfo.code === "") return;
         this.$refs.tableRef.getTableData(this.searchInfo, this.filterInfo);
      },
      filtering() {
         if (this.filterInfo.status === "") return;
         this.$refs.tableRef.getTableData(null, this.filterInfo);
      },
   },
};
</script>

<style lang="scss" scoped>
.reload-button,
.close-add-button {
   margin-left: 20px;
}
</style>
