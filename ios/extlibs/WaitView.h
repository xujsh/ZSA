//
//  WaitView.h
//  Zhouyu
//
//  Created by mac on 12-8-22.
//  Copyright (c) 2013年 Zhouyu All rights reserved.
//

#import <UIKit/UIKit.h>

@interface WaitView : UIView
{
    UIActivityIndicatorView *indicatorView;
}

@property (nonatomic, retain) UIView *parentView;
@property (nonatomic, retain) NSString *message;

- (id)initWithParentView:(UIView *)aParentView;
- (void)show;
- (void)hide;

@end
