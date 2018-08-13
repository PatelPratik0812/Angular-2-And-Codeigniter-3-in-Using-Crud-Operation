import { NgModule} from '@angular/core';
import { CommonModule } from '@angular/common';
import { BrowserModule } from '@angular/platform-browser';
import { CrudComponent } from './crud.component';
import { Routes, RouterModule } from '@angular/router';
import { DefaultComponent } from '../../default/default.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { APIService } from '../../../service/api.service';
import {GrowlModule, DialogModule,InputSwitchModule,CalendarModule,DataTableModule, ConfirmDialogModule,
        SharedModule,PaginatorModule,RatingModule, MultiSelectModule, ConfirmationService } from 'primeng/primeng';
import { ViewComponent } from './view/view.component';
import { from } from 'rxjs/observable/from';
import { MessageService } from 'primeng/components/common/messageservice';


const routes: Routes = [
  {
      path: "",
      component: CrudComponent,
      children: [
          {
              path: "",
              component: CrudComponent,
              children: [
                  { path: 'view', component: ViewComponent },
                  { path: '', component: ViewComponent }
              ]
          }
      ]
  },
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    FormsModule, ConfirmDialogModule,
    ReactiveFormsModule,
    DialogModule,
    InputSwitchModule,
    CalendarModule,
    DataTableModule,
    SharedModule,
    PaginatorModule,
    RatingModule,
    GrowlModule,
    MultiSelectModule
  ],
  declarations: [
    //DefaultComponent,
    CrudComponent,
    ViewComponent
  ],
  providers:[APIService,MessageService,ConfirmationService]
})
export class CrudModule { }
