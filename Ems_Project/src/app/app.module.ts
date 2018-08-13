import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { RouterModule,Routes } from '@angular/router';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { APIService } from 'app/service/api.service';
import { MessageService } from 'primeng/components/common/messageservice';
import { LoomModule } from 'app/pages/LoomManagement/Loom/loom.module';
import { MultiSelectModule } from 'primeng/primeng';
import { HeaderComponent } from 'app/pages/LoomManagement/Common/header/header.component';
import { FooterComponent } from 'app/pages/LoomManagement/Common/footer/footer.component';
import { CrudModule } from './pages/LoomManagement/Crud/crud.module';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    FormsModule,
    HttpModule,
    AppRoutingModule,
    LoomModule,
    CrudModule,
    MultiSelectModule,
   
  ],
  providers: [APIService,MessageService],
  bootstrap: [AppComponent]
})
export class AppModule { }
