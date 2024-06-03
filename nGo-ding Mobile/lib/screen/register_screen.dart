import 'package:firebase_auth/firebase_auth.dart';
import 'package:flutter/material.dart';
import 'package:wmk/providers/firebase_auth.dart';
import 'package:wmk/providers/firebase_firestore.dart';
import 'package:wmk/screen/home_screen.dart';
import 'package:wmk/screen/login_screen.dart';

class RegisterScreen extends StatefulWidget {
  const RegisterScreen({Key? key, required String title}) : super(key: key);

  @override
  // ignore: library_private_types_in_public_api
  _RegisterScreenState createState() => _RegisterScreenState();
}

final FirebaseAuthService _auth = FirebaseAuthService();
final FirebaseFirestoreService _firestoreService = FirebaseFirestoreService();

TextEditingController _usernameController = TextEditingController();
TextEditingController _emailController = TextEditingController();
TextEditingController _passwordController = TextEditingController();

@override
void dispose() {
  _usernameController.dispose();
  _emailController.dispose();
  _passwordController.dispose();
}

class _RegisterScreenState extends State<RegisterScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        toolbarHeight: 40,
        backgroundColor: Colors.white,
        elevation: 0,
        leading: Padding(
          padding: const EdgeInsets.fromLTRB(10, 10, 0, 0),
          child: IconButton(
            icon: const Icon(Icons.arrow_back),
            color: Colors.black,
            onPressed: () {
              Navigator.of(context).pop();
            },
          ),
        ),
      ),
      backgroundColor: Colors.white,
      body: Padding(
        padding: const EdgeInsets.fromLTRB(20, 20, 20, 0),
        child: ListView(
          shrinkWrap: true,
          children: [
            const Text(
              "Nama Lengkap",
              style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 10),
            TextField(
              controller: _usernameController,
              decoration: InputDecoration(
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(10.0),
                ),
                hintText: "Contoh: Alfaturahman",
              ),
            ),
            const SizedBox(height: 20),
            const Text(
              "No. Ponsel",
              style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 10),
            TextField(
              decoration: InputDecoration(
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(10.0),
                ),
                hintText: "Contoh: 08956776644",
              ),
            ),
            const SizedBox(height: 20),
            const Text(
              "Email (Pastikan email sudah benar)",
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
            const SizedBox(height: 20),
            const Text(
              "Buat Kata Sandi",
              style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 10),
            TextField(
              controller: _passwordController,
              decoration: InputDecoration(
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(10.0),
                ),
                hintText: "Contoh: Sandi123!",
              ),
            ),
            // const SizedBox(height: 20),
            // const Text(
            //   "Ulangi Kata Sandi",
            //   style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold),
            // ),
            // const SizedBox(height: 10),
            // TextField(
            //   decoration: InputDecoration(
            //     border: OutlineInputBorder(
            //       borderRadius: BorderRadius.circular(10.0),
            //     ),
            //     hintText: "Contoh: Sandi123!",
            //   ),
            // ),
            const SizedBox(height: 20),
            Row(
              children: [
                Icon(
                  Icons.check_circle_rounded,
                  color: Colors.blue[600],
                ),
                const SizedBox(width: 8),
                Text(
                  'Harus 8-20 Karakter',
                  style: TextStyle(
                      color: Colors.grey[400],
                      fontSize: 15,
                      fontWeight: FontWeight.normal),
                )
              ],
            ),
            const SizedBox(height: 10),
            Row(
              children: [
                Icon(
                  Icons.check_circle_rounded,
                  color: Colors.blue[600],
                ),
                const SizedBox(width: 4),
                Text(
                  "Harus ada min. 1 angka atau simbol (!@#%)",
                  style: TextStyle(
                      color: Colors.grey[400],
                      fontSize: 15,
                      fontWeight: FontWeight.normal),
                )
              ],
            ),
            const SizedBox(height: 25),
            Row(
              children: [
                Expanded(
                  child: ElevatedButton(
                    onPressed: () {
                      _signUP();
                      Navigator.push(context,
                          MaterialPageRoute(builder: (builder) {
                        return const LoginScreen();
                      }));
                    },
                    style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.blue,
                        shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(10))),
                    child: const Padding(
                      padding: EdgeInsets.symmetric(vertical: 15.0),
                      child: Text(
                        'Selanjutnya',
                        style: TextStyle(
                          color: Colors.white,
                          fontWeight: FontWeight.bold,
                          fontSize: 18,
                        ),
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
      // ),
    );
  }

  void _signUP() async {
    String username = _usernameController.text;
    String email = _emailController.text;
    String password = _passwordController.text;

    try {
      User? user = await _auth.signUpWithEmailAndPassword(email, password);

      if (user != null) {
        // Simpan data pengguna ke Firebase Firestore.
        await _firestoreService.addUser(
          userId: user.uid,
          username: username,
          email: email,
          // Tambahkan data lain jika perlu.
        );
        print("User is Successfully Created");
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => const LoginScreen()),
        );
      } else {
        print("Some error happened");
      }
    } catch (e) {
      print("Error during sign-up: $e");
      // Handle the error appropriately, e.g., show an error message to the user.
    }
  }
}
