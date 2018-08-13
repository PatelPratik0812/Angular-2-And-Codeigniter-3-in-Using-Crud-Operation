import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { DefaultComponent } from '../app/pages/default/default.component';

const routes: Routes = [
    {
        path: "",
        component: DefaultComponent,
        children: [
            {
                path: "loom",
                loadChildren: ".\/pages\/LoomManagement\/Loom\/loom.module#LoomModule"
            },
            {
                path: "crud",
                loadChildren: ".\/pages\/LoomManagement\/Crud\/crud.module#CrudModule"
            }
           
           
        ]
    }
];


@NgModule({
    imports: [RouterModule.forRoot(routes,{useHash:true})],
    exports: [RouterModule]
})
export class AppRoutingModule { }