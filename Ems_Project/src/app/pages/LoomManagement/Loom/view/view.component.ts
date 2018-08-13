import { Component, OnInit } from '@angular/core';
import {MultiSelectModule, GrowlModule, SelectItem, DialogModule, InputSwitchModule, CalendarModule, DataTableModule, SharedModule, PaginatorModule, RatingModule } from 'primeng/primeng';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { Router, ActivatedRoute, NavigationExtras } from '@angular/router';
import { Response2 } from 'app/shared/Response';
import { from } from 'rxjs/observable/from';
import { Response } from '@angular/http/src/static_response';
import { Loom } from 'app/pages/LoomManagement/Loom/Loom';
import { Message } from 'primeng/components/common/api';
import { MessageService } from 'primeng/components/common/messageservice';
import { Constant } from 'app/Shared/Constant';
import { APIService } from 'app/service/api.service';
import { Global } from '../../../../Shared/Global';


class LoomList implements Loom {

  constructor(public Id?,public Code?, public Name?, public Description?) { }
}

@Component({
  selector: 'app-view',
  templateUrl: './view.component.html',
  styleUrls: ['./view.component.css']
})
export class ViewComponent implements OnInit {

  msgs: Message[] = [];
  displayDialog: boolean;
  isSubmitted: boolean;
  loom: Loom = new LoomList();
  LoomForm: FormGroup;
  formData = new FormData();
  selectedLoom: Loom;
  newLoom: boolean;
  looms: Loom[];
  Response: Response2;

  // Page title
  title = Constant.LoomPageTitle;
  dialogtitle = Constant.AddDialogLoom;
  cols: any[];
  columnOptions: SelectItem[];
  BASE_URL;

  constructor(private api: APIService, public formBuilder: FormBuilder, private router: Router,private messageService: MessageService) { }

  ngOnInit() {
    this.getLoomList();

    this.setDefaultValuesForRequestForm();

    this.cols = [
      {field: 'Id', header: 'Id'},
      {field: 'Name', header: 'Name'},
      {field: 'Code', header: 'Code'},
      {field: 'Description', header: 'Description'}
  ];
  
  this.columnOptions = [];
  for(let i = 0; i < this.cols.length; i++) {
      this.columnOptions.push({label: this.cols[i].header, value: this.cols[i]});
  }

  }

  cloneLoom(c: Loom): Loom {
    let loom = new LoomList();
    for (let prop in c) {
      loom[prop] = c[prop];
    }
    return loom;
  }

  getLoomList() {
    this.api.get('loom/getrows?Status=').subscribe(response => {
     
      this.looms = response.data;
    });
  }

  setDefaultValuesForRequestForm() {
    this.LoomForm = this.formBuilder.group({
      firstname: [null],
      password: [null, [Validators.required]],
      country: [null],
      email: [null]
    });
  }

  showDialogToAdd() {
    this.dialogtitle = Constant.AddDialogLoom;
    this.newLoom = true;
    this.loom = new LoomList();
    this.LoomForm.patchValue({
      Id: "",
      Name: "",
      Code: "",
      Description: ""
    });
    this.displayDialog = true;
  }

  save(formData) {

    this.isSubmitted = true;
    
        if (formData.valid) {
          this.api.post('loom/Insertupdate', formData.value).subscribe(response => {
            this.Response = response;
            if (response.status == "TRUE") {
              this.showSuccess(response.message);
            }
            else if (response.status == "FALSE"){
              this.showError(response.message);
            }
          });
          this.getLoomList();
          this.loom = null;
          this.displayDialog = false;
        }
        else
        {

        }
    
  }

  delete() {
    this.api.get('loom/delete?id=' + this.loom.Id).subscribe(response => {
      this.Response = response;

      if (response.status == "TRUE") {
        this.showSuccess(response.message);
      }
      else if (response.status == "FALSE"){
        this.showError(response.message);
      }


    });
    this.getLoomList();

    this.loom = null;
    this.displayDialog = false;
  }

  onRowSelect(event) {
    this.newLoom = false;
    this.dialogtitle = Constant.EditDialogLoom;
    this.loom = this.cloneLoom(event.data);
    this.LoomForm.patchValue({
      Id: event.data.Id,
      Name: event.data.Name,
      Code: event.data.Code,
      Description: event.data.Description
    });

    this.displayDialog = true;
  }

  showSuccess(message: any) {
    this.msgs = [];
    this.msgs.push({ severity: 'success', summary: 'Success Message', detail: message });
  }

  showError(message: any) {
    this.msgs = [];
    this.msgs.push({ severity: 'error', summary: 'Error Message', detail: message });
  }

  clear() {
    this.msgs = [];
  }

}

