import { CommonModule } from "@angular/common";
import { Component, OnInit } from "@angular/core";
import { FormBuilder, FormGroup, ReactiveFormsModule } from "@angular/forms";
import { Router } from "@angular/router";

@Component({
    selector: "app-login-form",
    templateUrl: "./login-form.html",
    styleUrls: ["./login-form.css"],
    imports: [
        CommonModule,
        ReactiveFormsModule,
    ]
})
export class LoginFormComponent implements OnInit {
    form!: FormGroup;
    
    constructor(private formBuilder: FormBuilder, private router: Router) {}

    ngOnInit() {
        this.form = this.formBuilder.group({
            username: [''],
            password: ['']
        });
    }

    login() {
        if (this.form.valid) {
            const username = this.form.value.username;
            const password = this.form.value.password;
            if (username === 'admin' && password === 'admin') {
                alert('Login successful!');
                this.router.navigate(['/admin']);
            } else {
                alert('Invalid username or password');
            }
        }
    }
}