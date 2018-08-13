import { Component, OnInit } from '@angular/core';
import {MultiSelectModule, GrowlModule, SelectItem, DialogModule, InputSwitchModule, CalendarModule, ConfirmDialogModule,
        DataTableModule, SharedModule, PaginatorModule, RatingModule, ConfirmationService } from 'primeng/primeng';
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
  registerForm:FormGroup;
  CrudForm: FormGroup;
  selectedCode = []
  msgs: Message[] = [];
  displayDialog: boolean;
  EditdisplayDialog:boolean;
  isSubmitted: boolean;
  isUpdated: boolean = false;
  updateSubmitted:boolean;
  isFormSubmitted: boolean = false;
  loom: Loom = new LoomList();
  SelectedStatus: string[] = [];
  LoomForm: FormGroup;
  formData = new FormData();
  insertData = new FormData;
  selectedLoom: Loom;
  newLoom: boolean;
  looms: Loom[];
  Response: Response2;
  isDeleteShow: boolean;
  result = [];
record:any[];
status: any = [];
isActive: boolean = true;
displayButton: boolean = false;
  // Page title
  title = Constant.LoomPageTitle;
  dialogtitle = Constant.AddDialogLoom;
 
  cols: any[];
  columnOptions: SelectItem[];
  BASE_URL;
  Active = Constant.ACTIVE;
  InActive = Constant.INACTIVE;

  constructor(private api: APIService,private confirmationService: ConfirmationService ,public formBuilder: FormBuilder, private router: Router,private messageService: MessageService) { 
    this.status = [
      { label: 'Active', value: 'Active' },
      { label: 'InActive', value: 'InActive' }
    ];
  }

  ngOnInit() {
    //this.getLoomList();
   this.getrecord();
    this.setDefaultvalue();
   
    this.setDefaultValuesForRequestForm();

    this.cols = [
      {field: 'username', header: 'User Name'},
      {field: 'password', header: 'Password'}
      //{field: 'Status', header:'Status'}
      // {field: '', header: 'Action'}
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

  // getLoomList() {
  //   this.api.get('loom/getrows?Status=').subscribe(response => {
     
  //     this.looms = response.data;
  //   });
  // }

  setDefaultValuesForRequestForm() {
    this.LoomForm = this.formBuilder.group({
      Id: [null],
      Name: [null, [Validators.required]],
      Code: [null],
      Description: [null]
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
         // this.getLoomList();
          this.loom = null;
          this.displayDialog = false;
        }
        else
        {

        }
    
  }

  // delete() {
  //   this.api.get('loom/delete?id=' + this.loom.Id).subscribe(response => {
  //     this.Response = response;

  //     if (response.status == "TRUE") {
  //       this.showSuccess(response.message);
  //     }
  //     else if (response.status == "FALSE"){
  //       this.showError(response.message);
  //     }


  //   });
  //   this.getLoomList();

  //   this.loom = null;
  //   this.displayDialog = false;
  // }

  // onRowSelect(event) {
  //   this.newLoom = false;
  //  // this.dialogtitle = Constant.EditDialogLoom;
  //   this.loom = this.cloneLoom(event.data);
  //   this.LoomForm.patchValue({
  //     Id: event.data.Id,
  //     Name: event.data.Name,
  //     Code: event.data.Code,
  //     Description: event.data.Description
  //   });

  //   this.displayDialog = true;
  // }

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
  setDefaultvalue(){
    this.registerForm = this.formBuilder.group({
      reg_id: [null],
      username: [null],
      password: [null]
     
    });
    this.isFormSubmitted = false;
  }

  insertRecord(){
    this.isFormSubmitted = true;
    if(this.registerForm.valid){
      
        this.api.post('Loom/InsupdateCrud', this.registerForm.value).subscribe(response => {
        this.result = response;
        this.setDefaultvalue();
    this.getrecord();
    });
    this.showSuccess("Details Added");
    
      console.log('dgfjsfjg', this.registerForm.value);
    }
    
  
  }
  getrecord()
  { this.record = [];
    console.log("hgfgjhgjhgfjgfj", this.record);
    this.api.get('Loom/getData').subscribe(response => {
      console.log("hgfgj", response);
      this.record = response.record;
       this.selectedCode=[];
 });
 
}
deleterecord(event){
console.log('sdgfdsgjsdgf', event.reg_id);
this.api.get('Loom/delData?reg_id=' + event.reg_id).subscribe(response => {
  console.log(response);
  this.getrecord();
});
  this.showSuccess("Record Deleted");
  this.selectedCode=[];
}

EditData(data){
 this.isUpdated = true; 
 this.registerForm.patchValue({
    reg_id : data.reg_id,
    username:data.username,
    password:data.password 
  });
console.log("dfgsdgdfgdg",data.reg_id);
// this.api.post('Loom/InsupdateCrud ',data.reg_id).subscribe(response =>{
//   this.Response = response;
//   console.log("sdfds",response);
//});
}
StatusUpdate(data){
console.log("hgkhk",data);
// let newstatus;
// if(data.Status == this.Active){
//   newstatus = this.InActive;
//   console.log(newstatus);  
// }else{
//   newstatus = this.Active;
//   console.log(newstatus); 
// }

this.api.post('Loom/updateStatus', {'reg_id':data.reg_id,'Status':data.Status}).subscribe(response => {
  this.result = response;
  this.getrecord();
});
this.showSuccess("Status Updaated SuceessFully");

}
// showButton(event){
//   console.log(event.data);
//   //this.displayButton = event.originalEvent.checked;
//   if(event.originalEvent.checked){
//     this.displayButton = true;
//     console.log("if");
//   }else{
//     this.displayButton = false;
//    // console.log("else");
//   }

// }


onRowSelect(event){
  var selectedCount = this.selectedCode.length;
  this.isDeleteShow = (selectedCount >0);
  $(".PATotalRowsSelected").html("(" + selectedCount + " selected)");
}
onRowUnselect(event) {

  var selectedCount = this.selectedCode.length;
    this.isDeleteShow = (selectedCount >0);
  $(".PATotalRowsSelected").html("(" + selectedCount + " selected)");

}
onHeaderCheckboxToggle() {
  var selectedCount = this.selectedCode.length;
  this.isDeleteShow = (selectedCount >0);
  this.isDeleteShow = selectedCount == 0 ? false : true;
  $(".PATotalRowsSelected").html("(" + selectedCount + " selected)");
}
CrudActionSelected(Action) {
   //let x = [];
  //  if(Action != Delete){

  //  }else{ x=Action; }
//   for(let i = 0; i < this.selectedCode.length; i++){
//     x.push([ {value: this.selectedCode[i].Status },
//              {value: Action}
//           ]);
//  }
  let reqdata = {
      "Data": this.selectedCode,
      "Action": Action,
      "Table": "registration"
       }
      console.log("dfdsfsf",reqdata);
      this.api.post('Loom/CrudActionang',reqdata).subscribe(response => {
      // this.Response = response;
      console.log(response);

      let str = ""
      for (let i = 0; i < response.data.length; i++) {
          str = response.data[i] + str
      }

      if (response.status == "TRUE") {
          this.showSuccess(response.message + str);
      }
      else if (response.status == "FALSE") {
          this.showError(response.message);
      }

      this.isDeleteShow = !this.isDeleteShow
      //this.selectedCode = []
    

  });

}
confirm_action(Action) {
  console.log(Action);
  this.confirmationService.confirm({
      message: 'Are you sure that you want to perform this action?',
      accept: () => {
      this.CrudActionSelected(Action);
      }
  });
}


ActiveAll(selectedCode){
  for(let i=0;i<selectedCode.length;i++)
  {
      selectedCode[i].Status = "InActive";
      console.log(selectedCode[i].Status);
      this.api.post('Loom/updateStatus',this.selectedCode[i]).subscribe(response => {
        this.Response = response;
        if (response.status == true) {
          this.showSuccess(response.message);
        }
        else if (response.status == false){
          this.showError(response.message);
        }
        this.getrecord();
        this.showSuccess("Status Updaated SuceessFully");

      });
 
    }

}
InActiveAll(selectedCode){
  for(let i=0;i<selectedCode.length;i++)
    {
        selectedCode[i].Status = "Active";
        console.log(selectedCode[i].Status);
        this.api.post('Loom/updateStatus',this.selectedCode[i]).subscribe(response => {
          this.Response = response;
          if (response.status == true) {
            this.showSuccess(response.message);
          }
          else if (response.status == false){
            this.showError(response.message);
          }
          this.getrecord();
          this.showSuccess("Status Updaated SuceessFully");

        });
    }
  
  }
  DeleteAll(selectedCode){
    for(let i=0;i<selectedCode.length;i++)
    {
      this.api.get('Loom/delData?reg_id=' + selectedCode[i].reg_id).subscribe(response => {
        this.Response = response;
        if (response.status == true) {
          this.showSuccess(response.message);
        }
        else if (response.status == false) {
          this.showError(response.message);
        }
        this.getrecord();
      });
      //this.registration = null;
    }
  }
  CkEditor()
  {
    console.log('editor');
  }

}



