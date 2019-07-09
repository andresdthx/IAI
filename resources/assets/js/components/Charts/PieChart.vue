<script>
import { Doughnut, mixins } from 'vue-chartjs'
import piecelabel from 'chart.piecelabel.js';

const { reactiveProp } = mixins;

export default {
  props: ['data', 'title'],
  extends: Doughnut,
  mixins: [reactiveProp],

  data() {
      return {
          options: {
            responsive: false, 
            maintainAspectRatio: true,

            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 20,
                    bottom: 0
                }
            },

            pieceLabel: {
                mode: 'percentage',
                precision: 1,
                fontSize: 15,
                fontStyle: 'bold',
                fontColor: 'white',
                overlap: false,
                //position: 'outside'
            },

            title: {
                display: false,
                text: this.title,
                fontSize: 48,
                fontFamily: 'Open Sans',
                fontWeight: 'bold',
                padding: 20
            },

            legend: {
                position: 'top',
                labels: {
                    fontStyle:	70,
                    fontFamily: 'Open Sans',
                    padding: 10,
                    boxWidth: 30
                }
            },

            styles: {
                cursor: 'pointer'
            },

            onClick	: (evt, data) => {
                if (_.size(data) > 0 ) {
                    this.$emit('click-pie', data[0]._index)
                }
            },

            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        return `${data.labels[tooltipItem.index]}: ${ ((data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] / _.sum(data.datasets[tooltipItem.datasetIndex].data)) * 100).toFixed(1) }%`;
                    }
                }
            }
    
        }
      }
  },

  methods: {
    drawSegmentValues: function() {
     
    }
  },
 
  mounted () {
    this.renderChart(this.chartData, this.options);

    this.drawSegmentValues();
  },

}

</script>
