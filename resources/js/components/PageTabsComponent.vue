<template>
    <div>
        <button class="btn btn-secondary" type="button" @click="add">Добавить таб</button>
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

                    <span class="text"> Название : {{ element.name }} </span>

                    <input required="1" type="text" v-bind:name="'add_documents['+idx+'][name]'"  class="form-control"  v-model="element.name" />

                    <label for="">Контент</label>
                    <textarea  :id="'add_document-' + idx"  v-model.lazy="element.content" v-bind:name="'add_documents['+idx+'][content]'" class="form-control my-editor"></textarea>

                    <i class="fa fa-times close" @click="removeAt(idx)"></i>
                </li>
            </transition-group>

        </draggable>


    </div>

</template>
<script>

    let id = window.list_tab !== undefined ? window.list_tab.length-1: 0;
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
                list: window.list_tab,
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
                for (let id = 0; id < window.list_tab.length; id++) {
                    CKEDITOR.replace(`add_document-${id}`, {
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
                    CKEDITOR.replace(`add_document-${id}`, {
                        filebrowserBrowseUrl: '/elfinder',
                        filebrowserImageBrowseUrl: '/elfinder',
                        uiColor: '#9AB8F3',
                        height: 300
                    });
                }, 100);
                console.log($('#document-button-'+id));
            },
            kek:function(){

            },
            onChange:function(event){
                setTimeout(function(){
                    for (let id = 0; id < window.list_tab.length; id++) {
                        CKEDITOR.instances[`add_document-${id}`].destroy()
                    }
                }, 100);


                setTimeout(function(){
                    for (let id = 0; id < window.list_tab.length; id++) {
                        CKEDITOR.replace(`add_document-${id}`, {
                            filebrowserBrowseUrl: '/elfinder',
                            filebrowserImageBrowseUrl: '/elfinder',
                            uiColor: '#9AB8F3',
                            height: 300
                        });
                    }
                }, 100);

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