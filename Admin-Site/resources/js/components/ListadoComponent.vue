<template>
    <a-table :dataSource="lista" :columns="columns" :loading="loading">
        <div slot="filterDropdown" slot-scope="{ setSelectedKeys, selectedKeys, confirm, clearFilters, column }" class='custom-filter-dropdown'>
            <a-input
                v-ant-ref="c => searchInput = c"
                :placeholder="`Buscar ${column.dataIndex}`"
                :value="selectedKeys[0]"
                @change="e => setSelectedKeys(e.target.value ? [e.target.value] : [])"
                @pressEnter="() => handleSearch(selectedKeys, confirm)"
                style="width: 188px; margin-bottom: 8px; display: block;"
            />
            <a-button
                type='primary'
                @click="() => handleSearch(selectedKeys, confirm)"
                icon="search"
                size="small"
                style="width: 90px; margin-right: 8px"
            >Buscar</a-button>
            <a-button
                @click="() => handleReset(clearFilters)"
                size="small"
                style="width: 90px"
            >Limpiar</a-button>
        </div>
        <a-icon slot="filterIcon" slot-scope="filtered" type='search' :style="{ color: filtered ? '#108ee9' : undefined }" />
        <template v-for="col in ['nombre', 'correo', 'fechaNacimiento']" :slot="col" slot-scope="text, record">
            <div :key="col">
                <a-input
                    v-if="record.editable"
                    style="margin: -5px 0"
                    :value="text"
                    @change="e => handleChange(e.target.value, record.id, col)"
                />
                <template v-else>{{text}}</template>
            </div>
        </template>
        <template slot="opciones" slot-scope="text, record">
            <div class='editable-row-operations'>
                <span v-if="record.editable">
                    <a @click="() => save(record.id)">Guardar</a>
                    <a-popconfirm title='Desea cancelar?' @confirm="() => cancel(record.id)">
                        <a>Cancelar</a>
                    </a-popconfirm>
                </span>
                <span v-else>
                    <a @click="() => edit(record.id)"><a-icon type="edit" /> Actualizar</a>
                </span>
            </div>
            <a-popconfirm
                v-if="lista.length"
                title="Desea eliminar?"
                @confirm="() => onDelete(record.id)">
                <a href="javascript:;"> <a-icon type="delete" /> Eliminar</a>
            </a-popconfirm>
        </template>
    </a-table>
</template>

<script>

    const lista =[];

    export default {
        data () {
            this.cacheData = lista.map(item => ({ ...item }))
            return {
                lista,
                searchText: '',
                searchInput: null,
                columns: [
                    {
                        title: 'Nombre',
                        dataIndex: 'nombre',
                        key: 'nombre',
                        scopedSlots: {
                            filterDropdown: 'filterDropdown',
                            filterIcon: 'filterIcon',
                            customRender: 'nombre'
                        },
                        onFilter: (value, record) => record.nombre.toLowerCase().includes(value.toLowerCase()),
                        onFilterDropdownVisibleChange: (visible) => {
                            if (visible) {
                                setTimeout(() => {
                                this.searchInput.focus()
                                },0)
                            }
                        },
                    }, 
                    {
                        title: 'Correo Electrónico',
                        dataIndex: 'correo',
                        key: 'correo',
                        scopedSlots: {
                            filterDropdown: 'filterDropdown',
                            filterIcon: 'filterIcon',
                            customRender: 'correo'
                        },
                        onFilter: (value, record) => record.correo.toLowerCase().includes(value.toLowerCase()),
                        onFilterDropdownVisibleChange: (visible) => {
                            if (visible) {
                                setTimeout(() => {
                                this.searchInput.focus()
                                })
                            }
                        },
                    }, 
                    {
                        title: 'Fecha de Nacimiento',
                        dataIndex: 'fechaNacimiento',
                        key: 'fechaNacimiento',
                        scopedSlots: {
                            filterDropdown: 'filterDropdown',
                            filterIcon: 'filterIcon',
                            customRender: 'fechaNacimiento'
                        },
                        onFilter: (value, record) => record.fechaNacimiento.toLowerCase().includes(value.toLowerCase()),
                        onFilterDropdownVisibleChange: (visible) => {
                            if (visible) {
                                setTimeout(() => {
                                this.searchInput.focus()
                                })
                            }
                        },
                    }, 
                    {
                        title: 'Fotografía',
                        dataIndex: 'foto',
                        key: 'foto',
                    }, 
                    {
                        title: 'Opciones',
                        key: 'opciones',
                        scopedSlots: { 
                            customRender: 'opciones'
                        },
                    }
                ],
                loading: false
            }
        },
        created: function () { 
            this.getAll();
        },
        methods: {
            getAll(){
                this.loading = true;
                axios.get('/api/personas') 
                    .then(response => {
                        this.lista = response.data
                        this.loading = false
                    }) 
                    .catch(error => alert("error"));
            },
            handleChange (value, key, column) {
                const newData = [...this.lista]
                const target = newData.filter(item => key === item.id)[0]
                if (target) {
                    target[column] = value
                    this.lista = newData
                }
            },
            edit (key) {
                const newData = [...this.lista]
                const target = newData.filter(item => key === item.id)[0]
                if (target) {
                    target.editable = true
                    this.lista = newData
                }
            },
            save (key) {
     

                const newData = [...this.lista]
                const target = newData.filter(item => key === item.id)[0]
                console.log("salvando target...", target);
                
                if (target) {
                    delete target.editable
                    this.loading = true
                    axios.put(`/api/personas/${key}`, target) 
                        .then(response => {
                            this.getAll()
                            // delete target.editable
                            // this.lista = newData
                            this.loading = false
                            this.cacheData = newData.map(item => ({ ...item }))
                        }) 
                        .catch(error => alert("error"));
                }
            },  
            cancel (key) {
                const newData = [...this.lista]
                const target = newData.filter(item => key === item.id)[0]
                if (target) {
                    Object.assign(target, this.cacheData.filter(item => key === item.id)[0])
                    delete target.editable
                    this.lista = newData
                }
            },          
            handleSearch (selectedKeys, confirm) {
                confirm()
                this.searchText = selectedKeys[0]
            },
            handleReset (clearFilters) {
                clearFilters()
                this.searchText = ''
            },
            onDelete (key) {
                this.loading = true
                axios.delete(`/api/personas/${key}`) 
                    .then(response => {
                        this.getAll()
                        this.loading = true
                    }) 
                    .catch(error => alert("error"));
            },
        },
    }
</script>

<style scoped>
    .custom-filter-dropdown {
        padding: 8px;
        border-radius: 4px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
    }

    .highlight {
        background-color: rgb(255, 192, 105);
        padding: 0px;
    }
    .editable-row-operations a {
        margin-right: 8px;
    }
</style>