<template>
<div id="app">
    <div class="container px-0">
      <!--UPLOAD-->
      <form enctype="multipart/f    orm-data" novalidate v-if="isInitial">
        <!-- <h1>Upload images</h1> -->
        <div class="dropbox">
          <input type="file" multiple :name="uploadFieldName" :disabled="isSaving" @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length"
            class="input-file">
            <p v-if="isInitial">
              Arrastre aquí sus archivos<br> o haga clic para buscar
            </p>
            <p v-if="isSaving">
              Subiendo {{ fileCount }} archivo(s)...
            </p>
        </div>
      </form>
      <div v-else-if="isSaving">
        <button @click="reset">Eliminar</button>
        <!--   <ul v-if="uploadedFiles.length > 0">
            <li v-for="(item,key) in uploadedFiles" :key="key">  {{ title }} </li>
          </ul>  -->
      </div>
  </div>   
</div> 
</template>

<script>
//   import { upload } from './file-upload.service';

  const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;

  export default {
    name: 'app-files',
    props:{
      maxFiles: {
        type: Number,
        default: 1
      }
    },
    data() {
      return {
        uploadedFiles: [],
        currentStatus: null,
        uploadFieldName: 'photos'
      }
    },
    computed: {
      isInitial() {
        return this.currentStatus === STATUS_INITIAL;
      },
      isSaving() {
        return this.currentStatus === STATUS_SAVING;
      },
      isSuccess() {
        return this.currentStatus === STATUS_SUCCESS;
      },
      isFailed() {
        return this.currentStatus === STATUS_FAILED;
      }
    },
    methods: {
        emitInput (){
          console.log('llega')
          this.$emit('input', this.uploadedFiles)
        },
        reset() {
            // reset form to initial state
            this.currentStatus = STATUS_INITIAL;
            this.uploadedFiles = [];
            this.emitInput()
        },
        save(formData) {
            let archivos = [];
            // upload data to the server
            this.currentStatus = STATUS_SAVING;
            this.uploadedFiles.push(formData)
            this.emitInput()
        },
        filesChange(fieldName, fileList) {
            // handle file changes
            const formData = new FormData();
           
            const b64Files = [];
            const files = []
            if (!fileList.length) return;
            let count = 1;
            Object.keys(fileList).forEach( x => {
              if(count <= this.maxFiles){
                this.getBase64(fileList[x])
                .then(result => {
                    let data = {}
                    let name = fileList[x].name;
                    this.$set(data, 'file', result)
                    this.$set(data, 'title', name)
                    this.save(data);
                })
              }else{
                this.warningNotification('Unicamente es posible cargar ' + this.maxFiles + 'archivo(s)')
              }
                
                count ++;
            });
        },
        getBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => {
                let encoded = reader.result.replace(/^data:(.*;base64,)?/, '');
                if ((encoded.length % 4) > 0) {
                    encoded += '='.repeat(4 - (encoded.length % 4));
                }
                resolve(encoded);
                };
                reader.onerror = error => reject(error);
            });
        }
    },
    mounted() {
      this.reset();
    },
  }

</script>

<style lang="scss">
  .dropbox {
    outline: 2px dashed grey; /* the dash box */
    outline-offset: -10px;
    background: lightcyan;
    color: dimgray;
    padding: 10px 10px;
    min-height: 200px; /* minimum height */
    position: relative;
    cursor: pointer;
  }

  .input-file {
    opacity: 0; /* invisible but it's there! */
    width: 100%;
    height: 200px;
    position: absolute;
    cursor: pointer;
  }

  .dropbox:hover {
    background: lightblue; /* when mouse over to the drop zone, change color */
  }

  .dropbox p {
    font-size: 1.2em;
    text-align: center;
    padding: 50px 0;
  }
</style>
