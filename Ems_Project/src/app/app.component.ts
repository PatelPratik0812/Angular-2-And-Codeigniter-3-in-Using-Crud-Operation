import { Component, OnInit } from '@angular/core';

import { APIService } from '../app/service/api.service';

import { DialogModule, InputSwitchModule, CalendarModule, DataTableModule, SharedModule, PaginatorModule, RatingModule } from 'primeng/primeng';
import { Constant } from '../app/Shared/Constant';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent  {
  title = 'app works!';


  constructor(private api: APIService) { }

  ngOnInit() {
   
  }

 
}
