
<script>
     import {Doughnut} from 'vue-chartjs'
     import ChartDataLabels from 'chartjs-plugin-datalabels'

     Chart.helpers.merge(Chart.defaults.global.plugins.datalabels, {color: 'black'})

     export default {
         extends: Doughnut,
         plugins: ChartDataLabels,
         data () {
             return {
             }
         },
         props:{
             masiv:{
                 type:Array,
                 default: null
             },
             headers:{
                 type:Array,
                 default: null
             },
         },
         methods:{
             clickMouse(context){
                 this.$store.dispatch('SET_SEARCH', context.dataset.labels[context.dataIndex])
                 //console.log(this.$store.getters.SEARCH)
                 //console.log(context)
             },
             enterMove(context){
                 this.$store.dispatch('SET_SEARCH', context.dataset.labels[context.dataIndex])
                 //console.log(this.$store.getters.SEARCH)
                 //console.log(context)
             },
             leaveMove(context){
                 this.$store.dispatch('SET_SEARCH', '')
                 //console.log(this.$store.getters.SEARCH)
                 //console.log(context)
             },
             click(info){
                 console.log(info)
             }
         },
         watch:{
             masiv(){
                 console.log('Из AnyChart')
                 //this.$store.dispatch('SET_SEARCH','65')
                 this.renderChart({
                         labels: this.headers,
                         datasets:[{
                             backgroundColor: ['#F44336','#9C27B0','#3F51B5','#009688','#4CAF50','#CDDC39','#FFC107'],
                             data: this.masiv,
                             hoverBorderColor: 'black',
                             labels: this.headers,
                         }]
                     },
                     {
                         responsive: true,
                         maintainAspectRatio: false,
                         tooltips:{
                             enabled: false,
                             //mode: 'dataset'
                         },
                         title:{
                             display:true,
                             text:'по видам причин ГС, %'
                         },
                         legend:{
                             display: true,
                             position: 'bottom',
                             labels:{
                                 fontColor: '#263238'
                             }
                         },
                         plugins:{
                             datalabels:{
                                 color: 'white',
                                 labels:{
                                     title:{
                                         //rotation: 50,

                                         font:{
                                             weight: 'bold',
                                             size: 18,
                                         }
                                     },
                                     /*value:{
                                         color: 'green'
                                     }*/
                                 },
                                 // нажатие
                                 listeners:{
                                     click: this.clickMouse,
                                     //enter: this.enterMove,
                                     //leave: this.leaveMove,
                                 }
                             }
                         },
                         onClick: this.click
                     })
             },
         },
         mounted () {
             this.renderChart({
                     labels: this.headers,
                     datasets:[{
                         backgroundColor: ['#F44336','#9C27B0','#3F51B5','#009688','#4CAF50','#CDDC39','#FFC107'],
                         data: this.masiv,
                         hoverBorderColor: 'white',
                         labels: this.headers,
                     }]
                 },
                 {
                     responsive: true,
                     maintainAspectRatio: false,
                     tooltips:{
                         enabled: true
                     },
                     title:{
                         display:true,
                         text:'по видам причин ГС, %'
                     },
                     legend:{
                         display: true,
                         position: 'bottom',
                         labels:{
                             fontColor: '#263238'
                         }
                     },
                     plugins:{
                         datalabels:{
                             color: 'white',
                             labels:{
                                 title:{
                                     //rotation: 50,

                                     font:{
                                         weight: 'bold',
                                         size: 18,
                                     }
                                 },
                                 /*value:{
                                     color: 'green'
                                 }*/
                             },
                             // нажатие
                             listeners:{
                                 click: this.name,
                                 //enter: this.name
                             }
                         }
                     },
                 })
         },
     }
</script>
