<template>
    <div>
        <button class="btn btn-secondary" type="button" @click="add">Добавить блок отчетов</button>
        <draggable class="list-group"
                   tag="ul"
                   v-model="list"
                   v-bind="dragOptions"
                   @start="drag = true"
                   @end="drag = false"
                   @change="onChange">
            <transition-group type="transition" :name="!drag ? 'flip-list' : null">
                <li
                        class="list-group-item"
                        v-for="(element, idx) in list"
                        :key="element.id"

                >
                    <i class="fa fa-align-justify handle"></i>



                    <label for="">Контент</label>
                    <textarea  :id="'document-text-'+element.id"  v-model.lazy="element.content" v-bind:name="'documents['+idx+'][content]'" class="form-control "></textarea>

                    <div class="form-group">
                        <div class="input-group">
                                    <span class="input-group-btn">
                                      <a  :data-inputid="'document-' + element.id" :id="'document-button-'+element.id" class="btn  btn-primary popup_selector">
                                         <i class="fa fa-picture-o"></i> Выберите отчет ВЭК
                                        </a>
                                    </span>
                            <input :id="'document-' + element.id" required="1" style="pointer-events:none;" class="form-control" type="text"  v-model.lazy="element.file" v-bind:name="'documents['+idx+'][file]'" >
                        </div>
                        <input  type="text" :id="'document-filename-' + element.id"  v-model.lazy="element.filename" v-bind:name="'documents['+idx+'][filename]'" placeholder="Язык" class="form-control my-editor"/>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                                    <span class="input-group-btn">
                                      <a  :data-inputid="'document-decision-' + element.id" :id="'document-decision-button-'+element.id" class="btn  btn-primary popup_selector">
                                         <i class="fa fa-picture-o"></i> Выберите файл решения комиссии
                                        </a>
                                    </span>
                            <input :id="'document-decision-' + element.id" required="1" style="pointer-events:none;" class="form-control" type="text"  v-model.lazy="element.decision" v-bind:name="'documents['+idx+'][decision]'" >
                        </div>
                        <input  type="text" :id="'document-decisionname-' + element.id"  v-model.lazy="element.decisionname" v-bind:name="'documents['+idx+'][decisionname]'" placeholder="Язык" class="form-control my-editor"/>
                    </div>
                    <div class="input-group">
                                <span class="input-group-btn">
                                  <a  :data-inputid="'document-newfile-' + element.id" :id="'document-newfile-button-'+element.id" class="btn popup_selector btn-primary">
                                     <i class="fa fa-picture-o"></i> Выберите файл
                                    </a>
                                </span>
                        <input :id="'document-newfile-' + element.id"  style="pointer-events:none;" class="form-control" type="text"  v-model.lazy="element.newfile" v-bind:name="'documents['+idx+'][newfile]'" >
                    </div>
                    <input  type="text" :id="'document-newfilename-' + element.id"  v-model.lazy="element.newfilename" v-bind:name="'documents['+idx+'][newfilename]'" placeholder="Название файла" class="form-control my-editor"/>
                    <i class="fa fa-times close" @click="removeAt(idx)"></i>
                </li>
            </transition-group>

        </draggable>


    </div>

</template>
<script>

    let id = window.vek_text !== undefined ? window.vek_text.length-1: 0;
    import draggable from "vuedraggable";
    export default {
        name: "handle",
        display: "Transitions",
        instruction: "Перетащите за иконку",
        order: 5,
        components: {
            draggable
        },
        data() {
            return {
                list: window.vek_text,
                drag: false
            };
        },

        computed: {

            dragOptions() {
                return {
                    animation: 200,
                    group: "description",
                    disabled: false,
                    ghostClass: "ghost"
                };
            },
            draggingInfo() {
                return this.dragging ? "under drag" : "";
            }
        },
        mounted:function()
        {

            setTimeout(function(){
            for (let id = 0; id < window.vek_text.length; id++) {
                CKEDITOR.replace(`document-text-${id}`, {
                    filebrowserBrowseUrl: '/elfinder',
                    filebrowserImageBrowseUrl: '/elfinder',
                    uiColor: '#9AB8F3',
                    height: 300
                });
            }
        }, 100);


        },

        methods: {
            removeAt(idx) {
                this.list.splice(idx, 1);
            },
            add: function() {
                id++;
                this.list.push({ name: "Таб № " + id, id, content: "" });
                setTimeout(function(){
                    CKEDITOR.replace(`document-text-${id}`, {
                        filebrowserBrowseUrl: '/elfinder',
                        filebrowserImageBrowseUrl: '/elfinder',
                        uiColor: '#9AB8F3',
                        height: 300
                    });

                   // $('.document_input').filemanager('image');
                }, 100);
                console.log($('#document-button-'+id));
            },
            kek:function(){
               // $('.document_input').filemanager('image');
            },
            onChange:function(event){
                setTimeout(function(){
                    for (let id = 0; id < window.vek_text.length; id++) {
                        CKEDITOR.instances[`document-text-${id}`].destroy()
                    }
                }, 100);


                setTimeout(function(){
                    for (let id = 0; id < window.vek_text.length; id++) {
                        CKEDITOR.replace(`document-text-${id}`, {
                            filebrowserBrowseUrl: '/elfinder',
                            filebrowserImageBrowseUrl: '/elfinder',
                            uiColor: '#9AB8F3',
                            height: 300
                        });
                    }
                }, 100);

             //   $('.document_input').filemanager('image');
            },
            checkMove:function(event){

            }



        },



    };
</script>
<style scoped>
    .button {
        margin-top: 35px;
    }
    .flip-list-move {
        transition: transform 0.5s;
    }
    .no-move {
        transition: transform 0s;
    }
    .ghost {
        opacity: 0.5;
        background: #c8ebfb;
    }
    .list-group {
        min-height: 20px;
    }
    .list-group-item {
        cursor: move;
    }
    .list-group-item i {
        cursor: pointer;
    }
    .button {
        margin-top: 35px;
    }
    .handle {
        float: left;
        padding-top: 8px;
        padding-bottom: 8px;
    }
    .close {
        float: right;
        padding-top: 8px;
        padding-bottom: 8px;
        color: red;
        position:relative;
        z-index: 333333;
        opacity:1;

    }
    input {
        display: inline-block;
        width: 50%;
    }
    .text {
        margin: 20px;
    }
</style>
