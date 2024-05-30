import 'bootstrap';
import moment from 'moment';
import DataTable from 'datatables.net-bs5';
import select2 from 'select2';
import { createPopper } from '@popperjs/core';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

window.$ = $;
window.jQuery = $;
window.moment = moment;
window.DataTable = DataTable;
window.select2 = select2;
window.Popper = createPopper;
window.Chart = Chart;
