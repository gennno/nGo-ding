import 'package:firebase_auth/firebase_auth.dart';
import 'package:flutter/gestures.dart';
import 'package:flutter/material.dart';
import 'package:wmk/providers/firebase_auth.dart';
import 'package:wmk/screen/Choose_screen.dart';
import 'package:wmk/screen/home_screen.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({Key? key}) : super(key: key);

  @override
  // ignore: library_private_types_in_public_api
  _LoginScreenState createState() => _LoginScreenState();
}

final FirebaseAuthService _auth = FirebaseAuthService();

TextEditingController _emailController = TextEditingController();
TextEditingController _passwordController = TextEditingController();

@override
void dispose() {
  _emailController.dispose();
  _passwordController.dispose();
}

class _LoginScreenState extends State<LoginScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: Center(
        // Wrap the ListView with Center
        child: Padding(
          padding: const EdgeInsets.all(20.20),
          child: ListView(
            shrinkWrap:
                true, // Make the ListView take up only as much space as needed
            children: [
              const SizedBox(height: 10),
              SizedBox(
                height: 300,
                child: Image.asset(
                  "assets/logo/logo-login.png",
                  fit: BoxFit.contain,
                ),
              ),
              const Text(
                "Email",
                style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 10),
              TextField(
                controller: _emailController,
                decoration: InputDecoration(
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10.0),
                  ),
                  hintText: "Contoh: alfatur147@gmail.com",
                ),
              ),
              const SizedBox(height: 10),
              const Text(
                "Password",
                style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 10),
              TextField(
                controller: _passwordController,
                decoration: InputDecoration(
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10.0),
                  ),
                  hintText: "Contoh: sandi123",
                ),
              ),
              const SizedBox(height: 10),
              Row(
                children: [
                  Expanded(
                    child: CheckboxListTile(
                      value: false,
                      onChanged: (value) {},
                      controlAffinity: ListTileControlAffinity.leading,
                      title: const Text("Ingat Saya"),
                      contentPadding:
                          const EdgeInsets.symmetric(horizontal: 0.0),
                    ),
                  ),
                  RichText(
                    text: TextSpan(
                      recognizer: TapGestureRecognizer(),
                      text: 'Lupa Kata Sandi?',
                      style: const TextStyle(
                        fontSize: 15,
                        fontWeight: FontWeight.normal,
                        color: Colors.lightBlue,
                      ),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 20),
              Row(
                children: [
                  Expanded(
                    child: ElevatedButton(
                      onPressed: () {
                        _signIN();
                      },
                      style: ElevatedButton.styleFrom(
                          backgroundColor: Colors.blue,
                          shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(10))),
                      child: const Padding(
                        padding: EdgeInsets.symmetric(vertical: 16.0),
                        child: Text(
                          'MASUK',
                          style: TextStyle(
                            color: Colors.white,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 20),
              Center(
                child: RichText(
                  text: TextSpan(
                      text: "Belum Punya Akun?",
                      style: TextStyle(
                        fontSize: 15,
                        fontWeight: FontWeight.w600,
                        color: Colors.grey[500],
                      ),
                      children: [
                        const WidgetSpan(
                          child: SizedBox(width: 5),
                        ),
                        TextSpan(
                            recognizer: TapGestureRecognizer()
                              ..onTap = () {
                                Navigator.push(context,
                                    MaterialPageRoute(builder: (builder) {
                                  return const ChooseScreen();
                                }));
                              },
                            text: "Daftar",
                            style: const TextStyle(
                                color: Colors.lightBlue,
                                fontSize: 15,
                                fontWeight: FontWeight.bold))
                      ]),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  void _signIN() async {
    String email = _emailController.text;
    String password = _passwordController.text;

    try {
      User? user = await _auth.signInWithEmailAndPassword(email, password);

      if (user != null) {
        print("User is Successfully signIN");
        // ignore: use_build_context_synchronously
        Navigator.pushNamed(context, 'home');
      } else {
        print("Some error happened");
      }
    } catch (e) {
      print("Error during sign-in: $e");
      // Handle the error appropriately, e.g., show an error message to the user.
    }
  }
}
