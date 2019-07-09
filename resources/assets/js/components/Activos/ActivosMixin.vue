<script>
import swal from "sweetalert2";
import store from "../../store";
import { CONSTANTS as constants } from "../../constants";

export default {
  store,
  data() {
    return {
      multiSelect: "",
      values: {},
      files: ""
    };
  },

  computed: {
    data: function() {
      if (store.getters.dataReady) {
        let data = store.getters.step(this.step, this.initCheckedFiles);
        this.multiSelect = this.initMultiSelect(data);
        this.values = this.initValues(data);

        return data;
      }
      return "";
    },

    dataReady: _ => store.getters.dataReady,
    activo_id: _ => window.location.href.split("/")[5].replace("#", "")
  },

  methods: {

    getFileSize: function(size){
        let fileSize = Math.round((size * 0.001) * 100) / 100;
        if (fileSize > 1000) {
          fileSize = Math.round((size * 1e-6) *100) / 100;
          return `${fileSize}MB`;
        } else  {
          return `${fileSize}KB`;
        }
    },

    onDownloadFiles: function(id, name) {
      let ids = _.map(_.filter(this.data.fields[name].data, file => file.delete), file => file.id);

      axios.put('/activos/donwloadFiles', { idFiles: ids}).then( response => {
        console.log('ok');
      })

    },

    onDeleteSelectedFiles: function(name) {
      this.files[name] = _.filter(this.files[name], file => !file.delete);
    },

    checkAllSelectedFiles: function(name, e) {
      this.files[name] = _.map(this.files[name], file =>{
        file.delete = e.target.checked;
        return file
      })
      
    },

    checkAllFiles: function(name, value) {
        let val = value ? false : true;
        _.each(this.data.fields[name].data, (item, index) => {
          this.data.fields[name].data[index].delete = val;
        })
        
      },

    initCheckedFiles: function(data) {
      _.each(data.fields, item => {
          if(item == 'adjunto') {
            this.data.fields[item.name].selectAll = false;
            item.data = _.each(item.data, (adjunto, index) => {
                this.data.fields[item.name].data[index].delete = false;
            })
          }
      });
      return data;
    },

    initValues: function(data) {
      return ''
    }, 

    initFiles: function(data) {
      let createFiles = {};
      _.each(this.data.fields, field => {
        if (field.type == "adjunto") {
          createFiles[field.name] = [];
        }
      });
      return createFiles;
    },

    initMultiSelect: function(data) {
      let createMultiSelect = {};
      _.each(data.fields, field => {
        if (field.type == "select-multi") {
          if (field.name == 'herramientas') {
          } else {
            createMultiSelect[field.name] = data.fields[field.name].data || [];
          }
        }
      });
     
      return createMultiSelect;
    },


    onDeleteFiles: function(activoId, name) {
      let ids = _.map(_.filter(this.data.fields[name].data, item => item.delete), item => item.id);

      if (ids.length == 0) {
        swal({
          title: "No has seleccionado ningun archivo para eliminar",
          type: "warning",
          showCancelButton: false,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Continuar",
        }).then(result => {
          return;
        })
        return;
      }

      swal({
          title: "Estas seguro que deseas eliminar estos archivos?",
          text: "No podras deshacer esta acción",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, borrar!",
          cancelButtonText: "Cancelar",
          showLoaderOnConfirm: true,
          preConfirm: () => {
            return axios.delete(`/activos/deleteFiles/${activoId}`, {data : {idFiles: ids} }).then( response => {
              let data = response.data;
              store.commit("setActivo", data);
              return data;
            }).catch(e => {});

          },
          allowOutsideClick: () => !swal.isLoading()


      }).then(result => {
          if (result.value) {
            swal("Eliminado!", "Los archivos han sido eliminados.", "success");
          }
      });

    },

    deleteFile: function(activoId, fileId) {
      swal({
        title: "Estas seguro que deseas eliminar este archivo?",
        text: "No podras deshacer esta acción",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, borrar!",
        cancelButtonText: "Cancelar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return axios.delete(`/activos/deleteFile/${activoId}/${fileId}`).then(response => {
              let data = response.data;
              store.commit("setActivo", data);
              return data;
            })
            .catch(e => {});
        },
        allowOutsideClick: () => !swal.isLoading()


      }).then(result => {
        if (result.value) {
          swal("Eliminado!", "El archivo ha sido eliminado.", "success");
        }
      });
    },

    replaceSlash: function(fileId) {
      return fileId.replace("/", "-");
    },

    onFiles: function(e, name) {
      if (!this.files) {
        this.files = this.initFiles(this.data);
      }

      let x = this.files[name];
      
      let newFiles = e.target.files || e.dataTransfer.files;

      newFiles = _.map(newFiles, file => {
        file.delete = false;
        return file;
      });

      x.push(newFiles);

      newFiles = _.flatten(x);

      console.log(newFiles[0].size * 1e-6);

      this.files[name] = newFiles;
      
    },

    abortUpload: function(name, index) {
      this.files[name] = _.filter(this.files[name], (file, filterIndex) => filterIndex != index);

    },

    myPromise: function(ms, callback) {
      return new Promise(function(resolve, reject) {
          // Set up the real work
          callback(resolve, reject);

          // Set up the timeout
          setTimeout(function() {
              reject('Promise timed out after ' + ms + ' ms');
          }, ms);
      });
    },

    updateShowRequired(data, refs) {
      let fieldRequired = false;
      let updateData = data;
      _.map(data.fields, field => {

        if (field.required) {
          let required = false;

          if (field.reference_to) {
              
              if (field.type == "adjunto"){
                required = (refs[field.reference_to].value == "si" && (this.files[field.name].length == 0 && !this.data.fields[field.name].data));
              }else if(field.type == "select-multi") {
                required = refs[field.reference_to].value == field.reference_to_resp && this.multiSelect[field.name] == "";
              }else {
                required = refs[field.reference_to] && 
                           refs[field.reference_to].value == field.reference_to_resp && 
                           !refs[field.name].value;
              }
          } else if (field.type == "adjunto") {
           
          } else if (field.type == "select-multi") {
            required = this.multiSelect[field.name] == "" && data.finished;
          } else {
            
              if (refs[field.name]) {
                required = !refs[field.name].value && data.finished;
              } else {

              }
          }

          fieldRequired = required || fieldRequired;
          field.textAlert = required;
        }
        return field;
      });

      return { fieldRequired: fieldRequired, updateData: updateData };
    },

    getAllRequireds: function(data, refs) {
      let formData = new FormData();
      
      formData.append("step", data.step);
    
      _.each(data.fields, field => {
        
        if (field.name == 'herramientas'){
            formData.append(`${field.name}`, JSON.stringify(this.herramientas.values.dpis));
        }

        else if (field.type == "adjunto") {
          let currentFiles = this.files[field.name];
          _.each(Array.from(Array(currentFiles.length).keys()), x =>
            formData.append(`${field.name}[]`, currentFiles[x])
          );
        } else if (field.type == "select-multi") {

          _.each(this.multiSelect[field.name], item => {
            if (field.subValues) {
                formData.append(`${field.name}[]`, JSON.stringify({id: item.id, value: refs[`${field.name}/${item.id}`][0].value}));
            } else 
                formData.append(`${field.name}[]`, item.id);
          });

        } else {
          let data;

          if (this.values) {
            data = [];
            _.each(this.values[field.name], value => {if (!value.agregado) {data.push(value[field.name.slice(0, -1)])}} )
          } else {
            data = (refs[field.name] && refs[field.name].value) ? refs[field.name].value : "";

          }
           formData.append(field.name, data);
        }

      });

      return formData;
    },

    onSubmit: function(salir) {
      if (!this.files) {
        this.files = this.initFiles(this.data);
      }


      let dataRequired = this.updateShowRequired(this.data, this.$refs);

      if (dataRequired.fieldRequired) {
        let payload = {
          step: this.data.step,
          data: dataRequired.updateData
        };
     
        store.commit("setDataStep", payload);
        return;
      }

      let formData = this.getAllRequireds(this.data, this.$refs);

      let settings = { headers: { "content-type": "multipart/form-data" } };

      swal({
        title: 'Guardando información',
        allowOutsideClick: false
      });

      swal.showLoading();

      axios.post(`/activos/updates/${this.activo_id}`, formData, settings).then(response => {
          let data = response.data;
          this.files = this.initFiles(data);
          store.commit("setActivo", data);
          swal.close();
          if (data.finalizado && salir) {

            swal({
              title: "Finalizado",
              text: "Has terminado esta etapa",
              type: "success",
              showCancelButton: false,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#3085d6",
              confirmButtonText: "Aceptar",
              cancelButtonText: "Ver progreso del activo"
            }).then(response => {
              if (response.value) {
                this.$emit('closeStepFinalizado');
              }
            });
          } else {

            swal({
              type: "success",
              title: "Los datos han sido guardados",
              showConfirmButton: false,
              timer: 800
            });
          }
          //console.log(response);
        })
        .catch(e => {
          console.log(e.response);
          if (e.response.statusText == 'Payload Too Large') {
            swal({
              type: "error",
              title: `Los archivos adjuntos a guardar no deben de sobrepasar los ${store.getters.fileSize}MB`,
              showConfirmButton: true,
              confirmButtonText: "Aceptar"
            });
          } else {
            swal({
              type: "error",
              title: "Ha ocurrido un error",
              showConfirmButton: true,
              confirmButtonText: "Aceptar"
            });
            }
        });

    }
  }
};
</script>

