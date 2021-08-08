<div id="contact" class="sec-act">
    <div class="container slideanim section">
        <h2 class="contact-heading"> Liên hệ </h2>
        <p class="contact-desc"> Công nghệ vận chuyển tiên tiến, giao hàng nhanh chóng, đảm bảo chất lượng và yêu cầu
            tuyệt đối cho người dùng </p>
        <div class="contact-info row">
            <div class="my-contact col-6 ">
                <h3 class="my-contact-heading col-12"> Để lại lời nhắn</h3>
                <div class="my-contact-address col-12">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="address-icon bi bi-geo-alt-fill" viewBox="0 0 16 16">
                        <path
                            d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                    </svg>
                    <span>Địa chỉ</span></br>
                    <p class="address-text">144 Xuân Thủy, Dịch Vọng Hậu, Cầu Giấy, Hà Nội</p>
                </div>
                <div class="my-contact-email col-12">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="email-icon bi bi-envelope-fill" viewBox="0 0 16 16">
                        <path
                            d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z" />
                    </svg>
                    <span>Email</span>
                    </br>
                    <a class="email-text" href="mailto:phantrung18072001@gmail.com">daihoccongnghe@gmail.com</a>
                </div>
                <div class="my-contact-phone col-12">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="phone-icon bi bi-telephone-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                    </svg>
                    <span>Điện thoại</span>
                    </br>
                    <a class="phone-text" href="tel:0948999888">(+84) 123456789</a>
                </div>
            </div>
            <div class="your-contact col-6">
                <form action="{{ route('contact') }}" target="_self" id="contactForm" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-contact-control your-name">
                                <input type="text" class="name-input form-input" placeholder=" " name="name"
                                    maxlength="50" required
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                <label class="name-label form-label">Họ tên</label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-contact-control your-email">
                                <input type="email" class="email-input form-input" placeholder=" " name="email"
                                    maxlength="50" required
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                <label class="email-label form-label">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-contact-control your-subject">
                                <input type="text" class="subject-input form-input" placeholder=" " name="title"
                                    maxlength="50" required
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                <label class="subject-label form-label">Chủ đề</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-contact-control your-mess">
                                <textarea class="mess-input form-input" placeholder=" " rows="5" name="message"
                                    maxlength="5000" required
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                                <label class="mess-label form-label">Message</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn form-send">Gửi</button>
                </form>
            </div>
        </div>
    </div>
</div>
